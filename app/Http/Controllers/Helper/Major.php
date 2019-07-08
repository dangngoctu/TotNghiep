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

class Major extends Controller
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
    public function postMajor($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\MMajor::find($request->id);
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
                $check = Models\MMajor::where('id', '!=', $query->id)
                    ->whereHas('m_major_translations_all', function ($query_check) use ($request){
                        $query_check->where('name', $request->name)->where('language_id', $request->lang);
                    })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                if (count($data_relationship) > 0) {
                    $query->m_major_translations_all()->where('language_id', $request->lang)->update($data_relationship);
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
                
                $ref = Models\MMajorTranslation::where('translation_id', $request->id);
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
                $check = Models\MMajor::whereHas('m_major_translations_all', function ($query_check) use ($request){
                    $query_check->where('name', $request->name)->where('language_id', $request->lang);
                })->count();
                if($check > 0){
                    DB::rollback();
                    return false;
                }
                $query = Models\MMajor::create($data);
                if(!$query) {
                    DB::rollback();
                    return false;
                }
                
                $data_relationship['translation_id'] = $query->id;
					$trans = self::renderTrans($query->m_major_translations(), $data_relationship);
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
    
    public function getMajor($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MMajor::with('m_major_translations')
                    ->where('id', $id)
                    ->whereHas('m_major_translations', function ($query) use ($language) {
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

    public function getDTMajor()
    {
        self::__construct();
        try {
            $data = Models\MMajor::with('m_major_translations');
            return Datatables::of($data)
            ->editColumn('name', function ($v) {
                if(!empty($v->m_major_translations->name)) {
                    return $v->m_major_translations->name;
                } else {
                    return '';
                }
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('m_major_translations', function ($rs) use($keyword) {
                    $rs->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->addColumn('action', function ($v) {
                $action = '';
                if(1==1) {
                    $action .= '<span class="btn-action table-action-edit cursor-pointer tx-success" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-edit"></i></span>';
                }
                
                if(1==1) {
                    $action .= '<span class="btn-action table-action-delete cursor-pointer tx-danger mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-trash"></i></span>';
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
