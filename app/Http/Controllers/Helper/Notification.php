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
use Vmorozov\FileUploads\FilesSaver as Uploader;
use Illuminate\Http\UploadedFile;

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
    public function getNotification($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MNotificaiton::with('m_user','m_failure_mode.m_failure_mode_translations','m_device.m_device_translations','m_category.m_categories_translations')
                    ->where('id', $id)
                    ->first();
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
                
                if($user->hasRole(['hr', 'admin']) || $role_action == 1) {
                    $action .= '<span class="btn-action table-action-edit cursor-pointer tx-success" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-edit"></i></span>';
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

    public function postAddNotification($request){
        try{
            DB::beginTransaction();
            $data = [];
            $data['user_id'] = Auth::user()->id;
            $data['status'] = 1;
            if($request->has('category_id') && !empty($request->category_id)) {
                $data['category_id'] = $request->category_id;
            }
            if($request->has('device_id') && !empty($request->device_id)) {
                $data['device_id'] = $request->device_id;
            }
            if($request->has('failure_id') && !empty($request->failure_id)) {
                $data['failure_id'] = $request->failure_id;
            }
            if($request->has('comment') && !empty($request->comment)) {
                $data['comment'] = $request->comment;
            }
            if($request->has('logo') && !empty($request->logo)) {
                $dir = public_path('img/images_notification');
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0777, true, true);
                }
                $name_image_logo = 'notification_'.time().'.'.$request->logo->getClientOriginalExtension();
                $data['file'] = 'img/images_notification/'.$name_image_logo;
            } else {
                if($request->fileListLogo == 0) {
                    $data['file'] = null;
                }
            }
            if($request->action == 'delete'){
                if(!$request->id){
                    DB::rollback();
                    return false;
                }
                $query_delete = Models\MNotificaiton::where('id', $request->id)->first();
                if($query_delete){
                    $query_delete->delete();
                    DB::commit();
                } else {
                    DB::rollback();
                    return false;
                }
            } else {
                if(count($data) >0){
                    $query = Models\MNotificaiton::insert($data);
                    if(!$query){
                        DB::rollback();
                        return false;
                    } else {
                        DB::commit();
                        if($request->has('logo') && !empty($request->logo)) {
                            if(!empty($name_image_logo)) {
                                Uploader::uploadFile($request->logo, 'img/images_notification', 'notification', false, $name_image_logo);
                            }
                        }
                    }
                }
            }
            
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function postUpdateNotification($request){
        try{
            DB::beginTransaction();
            $data = [];
            $query = Models\MNotificaiton::where('id', $request->id);
            if(!$query){
                DB::rollback();
                return false;
            }
            if($request->has('status') && !empty($request->status)) {
                $data['status'] = $request->status;
            }
            if($request->has('reason') && !empty($request->reason)) {
                $data['submit_comment'] = $request->reason;
            }
            if(count($data) > 0){
                $query->update($data);
                if(!$query){
                    DB::rollback();
                    return false;
                } else {
                    DB::commit();
                    return true;
                }
            } else {
                DB::rollback();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    //DEMO
}
