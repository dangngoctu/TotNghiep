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
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Auth;
use App\Models;
use Carbon\Carbon;


class FailureMode extends Controller
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
    public function postFailureMode($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\MFailureMode::find($request->id);
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
            if($request->has('category_id') && !empty($request->category_id)) {
                $data['category_id'] = $request->category_id;
            }
            
            if($request->action == 'update') {
                $check = Models\MFailureMode::where('status', 1)->where('id', '!=', $query->id)
                    ->whereHas('m_failure_mode_translations_all', function ($query_check) use ($request){
                        $query_check->where('name', $request->name)->where('language_id', $request->lang);
                    })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                if (count($data) > 0) {
                    $query->update($data);
                    if (!$query) {
                        DB::rollback();
                        return false;
                    }
                }
                if (count($data_relationship) > 0) {
                    $query->m_failure_mode_translations_all()->where('language_id', $request->lang)->update($data_relationship);
                    if (!$query) {
                        DB::rollback();
                        return false;
                    }
                }
            } else if($request->action == 'delete') {
                // $failure_mode_detail = Models\MFalureModeDetail::where('falure_id', $request->id);
                // if(count($failure_mode_detail->get()) > 0) {
                //     DB::rollback();
                //     return false;
                // }
                $noti = Models\MNotificaiton::where('failure_id', $request->id);
                if(count($noti->get()) > 0) {
                    DB::rollback();
                    return false;
                }
                $ref = Models\MFailureModeTranslation::where('translation_id', $request->id);
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
                $check = Models\MFailureMode::where('status', 1)->whereHas('m_failure_mode_translations_all', function ($query_check) use ($request){
                    $query_check->where('name', $request->name)->where('language_id', $request->lang);
                })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                $query = Models\MFailureMode::create($data);
                if(!$query) {
                    DB::rollback();
                    return false;
                }
                
                $data_relationship['translation_id'] = $query->id;
                $trans = self::renderTrans($query->m_failure_mode_translations(), $data_relationship);
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

    public function getFailureMode($id, $language = 1)
    {
        self::__construct();
        try {
            $data = Models\MFailureMode::with('m_failure_mode_translations', 'm_category')
            ->where('id', $id)
            ->whereHas('m_failure_mode_translations_all', function ($query) use ($language) {
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

    public function getDTFailureMode($categoryId = '')
    {
        self::__construct();
        try {
            $data = Models\MFailureMode::with('m_failure_mode_translations', 'm_category.m_categories_translations');
                if($categoryId) {
                    $data = Models\MFailureMode::with('m_failure_mode_translations')
                        ->whereHas('m_category',function ($query) use ($categoryId){
                            $query->where('id', $categoryId);
                        })->where('status', 1);
                    return $data->get();
                }
            return Datatables::of($data)
                ->editColumn('name', function ($v) {
                    if(!empty($v->m_failure_mode_translations->name)) {
                        return $v->m_failure_mode_translations->name;
                    } else {
                        return '';
                    }
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('m_failure_mode_translations', function ($rs) use($keyword) {
                            $rs->where('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->editColumn('category_name', function ($v) {
                    if(!empty($v->m_category->m_categories_translations->name)) {
                            return $v->m_category->m_categories_translations->name;
                    } else {
                            return '';
                    }
                })
            ->addColumn('action', function ($v) {
                $action = '';
                if(1==1) {
                    $action .= '<span class="btn-action table-action-edit cursor-pointer tx-success" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-edit"></i></span>';
                }
                
                if(1==1) {
                    $action .=  '<span class="btn-action table-action-delete cursor-pointer tx-danger mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-trash"></i></span>';
                }
                
                return $action;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }
    //DEMO
}
