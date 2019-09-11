<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use App\Models;
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Auth;
use Carbon\Carbon;

class Notification extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $lang;
    protected $lang_id;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
        $this->lang_id = LaravelLocalization::getSupportedLocales()[$this->lang]['id'];
    }

    //DEMO
    public function postNotification($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\MLine::find($request->id);
                if(!$query) {
                    DB::rollback();
                    return false;
                }
            }
            $data = [];
            $data_relationship = [];
            if($request->has('name') && !empty($request->name)) {
                $data_relationship['name'] = $request->name;
            }
            if($request->status == 'on') {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
					
            if($request->action == 'update') {
                $check = Models\MLine::where('id', '!=', $query->id)
                    ->whereHas('m_line_translations_all', function ($query_check) use ($request){
                        $query_check->where('name', $request->name)->where('language_id', $request->lang);
                    })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                if (count($data_relationship) > 0) {
                    $query->m_line_translations_all()->where('language_id', $request->lang)->update($data_relationship);
                    if (!$query) {
                        DB::rollback();
                        return false;
                    }
                }
                if (count($data) > 0) {
                    $query->update($data);
                    if (!$query) {
                        DB::rollback();
                        return false;
                    }
                }
            } else if($request->action == 'delete') {
                
                $ref = Models\MlineTranslation::where('translation_id', $request->id);
                $ref = $ref->delete();
                if(!$ref) {
                    DB::rollback();
                    return false;
                }
                $query->delete();
                if(!$query) {
                    DB::rollback();
                    return false;
                }
            } else {
                $check = Models\MLine::whereHas('m_line_translations_all', function ($query_check) use ($request){
                    $query_check->where('name', $request->name)->where('language_id', $request->lang);
                })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                $query = Models\MLine::create($data);
                if(!$query) {
                    DB::rollback();
                    return false;
                }
                
                $data_relationship['translation_id'] = $query->id;
					$trans = self::renderTrans($query->m_line_translations(), $data_relationship);
                if(!$trans) {
                    DB::rollback();
                    return false;
                }
            }
            if ($query) {
                DB::commit();
                return true;
            } else {
                DB::rollback();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function getNotification($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MLine::with('m_line_translations')
                    ->where('id', $id)
                    ->whereHas('m_line_translations', function ($query) use ($language) {
                        $query->where('language_id', $language);
                    })->first();
            if (!empty($data)) {
                return self::JsonExport(200, trans('app.success'), $data);
            } else {
                return self::JsonExport(404, trans('app.error_404'));
            }
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }

    public function getDTNotification()
    {
        $role_action = 0;
        self::__construct();
        try {
            $data = Models\MNotificaiton::whereNotNull('created_at');
            return Datatables::of($data)
            ->editColumn('creater', function ($v) {
                if(!empty($v->m_user->name)) {
                    return $v->m_user->name;
                } else {
                    return '';
                }
            })
            ->filterColumn('creater', function ($query, $keyword) {
                $query->whereHas('m_user', function ($rs) use($keyword) {
                    $rs->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->editColumn('device', function ($v) {
                if(!empty($v->m_device->m_device_translations->name)) {
                    return $v->m_device->m_device_translations->name;
                } else {
                    return '';
                }
            })
            ->editColumn('category', function ($v) {
                if(!empty($v->category_id)) {
                    return $v->m_category->m_categories_translations->name;
                } else {
                    return '';
                }
            })
            ->editColumn('failure', function ($v) {
                if(!empty($v->failure_id)) {
                    return $v->m_failure_mode->m_failure_mode_translations->name;
                } else {
                    return '';
                }
            })
            ->editColumn('status', function ($v) {
                if(!empty($v->status)) {
                    if($v->status == 1){
                        return 'New';
                    } elseif($v->status == 2){
                        return 'Confirm';
                    } else {
                        return 'Reject';
                    }
                } else {
                    return '';
                }
            })
            ->editColumn('image', function ($v) {
                if(!empty($v->file)) {
                    $url = asset($v->file);
                    return "<img src='".$url."' style='width:100px; height:70px'>";
                } else {
                    return '';
                }
            })

            ->addColumn('action', function ($v) {
                $action = '';
                $user = Auth::user();
                $role_action = 0;
                if($user->hasRole('manager')){
                    $area = Models\MArea::where('status', 1)->whereHas('m_devices', function ($query) use ($v){
                        $query->where('id', $v->device_id);
                    })->first();
                    if($area){
                        $line = Models\MLine::where('status', 1)->whereHas('m_areas', function ($query) use ($area){
                            $query->where('id', $area->line_id);
                        })->first();
                        if($line){
                            if($user->system_managements->line_id == $line->id){
                                $role_action = 1;
                            }
                        }
                    } 
                }
                if($v->status == 1){
                    if($user->hasRole(['hr', 'admin']) || $role_action == 1) {
                        $action .= '<span class="btn-action table-action-edit cursor-pointer tx-success" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-edit"></i></span>';
                    }
                }
                
                if($user->hasRole(['hr', 'admin']) || $role_action == 1){
                    $action .= '<span class="btn-action table-action-delete cursor-pointer tx-danger mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-trash"></i></span>';
                }
                
                return $action;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'image', 'category', 'failure', 'creater', 'device'])
            ->make(true);
        } catch (\Exception $e) {
            return false;
        }
    }
    //DEMO
}
