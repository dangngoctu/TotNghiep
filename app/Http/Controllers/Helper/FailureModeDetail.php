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
use Carbon\Carbon;
use App\Models;

class FailureModeDetail extends Controller
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
    public function postFailureModeDetail($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\MFalureModeDetail::find($request->id);
                if(!$query) {
                    DB::rollback();
                    return 1;
                }
            }
				if($request->action == 'update' || $request->action == 'insert') {
            	    $failure_id = $request->failure_id;
                        $queryName = Models\MFalureModeDetailTranslation::where('name', $request->name)
                                    ->where('language_id', $request->lang)
                                    ->where('translation_id', '!=', $request->id)
                                    ->whereHas('m_falure_mode_detail', function ($query) use ($failure_id){
                                        $query->where('falure_id',$failure_id);
                });
                if(count($queryName->get()) > 0) {
                    DB::rollback();
                    return 2;
                }
            }
            $data = [];
            $data_relationship = [];
            if($request->has('name') && !empty($request->name)) {
                $data_relationship['name'] = $request->name;
            }
            if($request->has('failure_id') && !empty($request->failure_id)) {
                $data['falure_id'] = $request->failure_id;
            }
            if($request->has('weight_factor') && !empty($request->weight_factor)) {
                $data['weight_factor'] = $request->weight_factor;
            }
            if($request->action == 'update') {
                if (count($data) > 0) {
                    $query->update($data);
                    if (!$query) {
                        DB::rollback();
                        return 3;
                    }
                }
                if (count($data_relationship) > 0) {
                    $query->m_falure_mode_detail_translations_all()->where('language_id', $request->lang)->update($data_relationship);
                    if (!$query) {
                        DB::rollback();
                        return 3;
                    }
                }
            } else if($request->action == 'delete') {
                $noti = Models\MNotification::where('falure_detail_id', $request->id);
                if(count($noti->get()) > 0) {
                    DB::rollback();
                    return 4;
                }
                $ref = Models\MFalureModeDetailTranslation::where('translation_id', $request->id);
                $ref = $ref->delete();
                if(!$ref) {
                    DB::rollback();
                    return 5;
                }
                $query->delete();
                if(!$query) {
                    DB::rollback();
                    return 5;
                }
            } else {
                $query = Models\MFalureModeDetail::create($data);
                if(!$query) {
                    DB::rollback();
                    return 6;
                }
                
                $data_relationship['translation_id'] = $query->id;
				$trans = self::renderTrans($query->m_falure_mode_detail_translations(), $data_relationship);
                if(!$trans) {
                    DB::rollback();
                    return 6;
                }
            }
            if ($query) {
                DB::commit();
                return true;
            } else {
                DB::rollback();
                return 7;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return 7;
        }
    }

    public function getFailureModeDetail($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MFalureModeDetail::with('m_falure_mode_detail_translations_all', 'm_falure_mode_detail_translations', 'm_falure_mode.m_category')
                    ->where('id', $id)
                    ->whereHas('m_falure_mode_detail_translations_all', function ($query) use ($language) {
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

    public function getDTFailureModeDetail()
    {
        self::__construct();
        try {
            $data = Models\MFalureModeDetail::with('m_falure_mode_detail_translations', 'm_falure_mode.m_falure_mode_translations', 'm_falure_mode.m_category.m_categories_translations');
            return Datatables::of($data)
            ->editColumn('name', function ($v) {
                    if(!empty($v->m_falure_mode_detail_translations->name)) {
                        return $v->m_falure_mode_detail_translations->name;
                    } else {
                        return '';
                    }
            })
            ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('m_falure_mode_detail_translations', function ($rs) use($keyword) {
                            $rs->where('name', 'LIKE', '%'.$keyword.'%');
                    });
            })
            ->editColumn('category_name', function ($v) {
                    if(!empty($v->m_falure_mode->m_category->m_categories_translations->name)) {
                            return $v->m_falure_mode->m_category->m_categories_translations->name;
                    } else {
                            return '';
                    }
            })
            ->editColumn('failure_mode', function ($v) {
                if(!empty($v->m_falure_mode->m_falure_mode_translations->name)) {
                    return $v->m_falure_mode->m_falure_mode_translations->name;
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
