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

class Course extends Controller
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
    public function postCourse($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\MCourse::find($request->id);
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
			if($request->has('major_id_modal') && !empty($request->major_id_modal)) {
				$data['major_id'] = $request->major_id_modal;
			}

			if($request->status == 'on') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
					
            if($request->action == 'update') {
				$check = Models\MCourse::where('id', '!=', $query->id)
					->whereHas('m_course_translations_all', function ($query_check) use ($request){
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
					$query->m_course_translations_all()->where('language_id', $request->lang)->update($data_relationship);
					if (!$query) {
						DB::rollback();
						return false;
					}
				}
            } else if($request->action == 'delete') {
				$class = Models\MClass::where('course_id', $request->id);
				if(count($class->get()) > 0) {
					DB::rollback();
					return false;
				}
				
                $ref = Models\MCourseTranslation::where('translation_id', $request->id);
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
            } else if($request->action == 'insertlist') {
                $list_name = str_replace("\r\n", "\n", trim($request->listname));
                $list_name = explode("\n", trim($list_name));
                foreach($list_name as $key => $val){
                    if(!empty($val) && $val != ''){
                        $check = Models\MCourse::whereHas('m_course_translations_all', function ($query_check) use ($request){
							$query_check->where('name', $request->name)->where('language_id', $request->lang);
						})->count();
                        if($check < 1){
                            $data_relationship['name'] = $val;
                        }
                        $query = Models\MCourse::create($data);
						if(!$query) {
							DB::rollback();
							return false;
						}
						
						$data_relationship['translation_id'] = $query->id;
						$trans = self::renderTrans($query->m_course_translations(), $data_relationship);
						if(!$trans) {
							DB::rollback();
							return false;
						}
                    }
                }
            } else {
				$check = Models\MCourse::whereHas('m_course_translations_all', function ($query_check) use ($request){
					$query_check->where('name', $request->name)->where('language_id', $request->lang);
				})->count();
				if($check > 0){
					DB::rollback();
					return false;
				}
                $query = Models\MCourse::create($data);
                if(!$query) {
                    DB::rollback();
                    return false;
                }
                
                $data_relationship['translation_id'] = $query->id;
				$trans = self::renderTrans($query->m_course_translations(), $data_relationship);
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

    public function getCourse($id, $language)
    {
        self::__construct();
        try {
            $data = Models\MCourse::with('m_course_translations', 'm_major.m_major_translations')
                    ->where('id', $id)
                    ->whereHas('m_course_translations', function ($query) use ($language) {
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

    public function getDTCourse($majorId = '')
    {
        self::__construct();
        try {
			if($majorId && !empty($majorId)) {
				$data = Models\MCourse::with('m_course_translations', 'm_major.m_major_translations')
					->whereHas('m_major',function ($query) use ($majorId){
						$query->where('id', $majorId);
					})->where('status', 1);
			} else {
				$data = Models\MCourse::with('m_course_translations','m_major.m_major_translations');
			}
			return Datatables::of($data)
				->editColumn('id', function ($v) {
						if(!empty($v)) {
							return $v->id;
						} else {
							return '';
						}
				})
				->editColumn('name', function ($v) {
						if(!empty($v->m_course_translations->name)) {
							return '' . $v->m_course_translations->name . '';
						} else {
							return '';
						}
				})
				->filterColumn('name', function ($query, $keyword) {
						$query->whereHas('m_course_translations', function ($rs) use($keyword) {
								$rs->where('name', 'LIKE', '%'.$keyword.'%');
						});
				})
				->editColumn('major_name', function ($v) {
						if(!empty($v->m_major->m_major_translations->name)) {
							return '' . $v->m_major->m_major_translations->name . '';
						} else {
							return '';
						}
				})
				->editColumn('status', function ($v) {
					if(!empty($v->status) && $v->status == 1) {
						return '<i class="fa fa-check-circle tx-success"></i>';
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
			->rawColumns(['action', 'status', 'name', 'site_name',])
			->make(true);
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }
    //DEMO
}
