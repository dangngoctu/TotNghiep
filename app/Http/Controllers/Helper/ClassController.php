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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Auth;
use Carbon\Carbon;
use App\Models;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ClassController extends Controller
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
    public function postClass($request)
    {
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = MDevice::find($request->id);
                if(!$query) {
                    DB::rollback();
                    return 1;
                }
			}
			if($request->action == 'update' || $request->action == 'insertlist' || $request->action == 'insert') {
				$check_manage_owner = SystemManagement::where('area_id', $request->area_id)->first();
				if(!$check_manage_owner){
					DB::rollback();
					return 10;
				}
				$check_manage_supervisor = SystemManagement::where('line_id', $request->line_id)->first();
				if(!$check_manage_supervisor){
					DB::rollback();
					return 10;
				}
			}
            $data = [];
            $data_relationship = [];
            if($request->has('name') && !empty($request->name)) {
				$data_relationship['name'] = $request->name;
            }
			if($request->has('area_id') && !empty($request->area_id)) {
				$data['area_id'] = $request->area_id;
			}
			if($request->has('device_code') && !empty($request->device_code)) {
				$data['device_code'] = $request->device_code;
			} else {
				$data['device_code'] = md5(rand().time());
			}
			if($request->status == 'on') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
					
            if($request->action == 'update') {
				$check = MDevice::where('id', '!=', $query->id)
					->whereHas('m_device_translations_all', function ($query_check) use ($request){
						$query_check->where('name', $request->name)->where('language_id', $request->lang);
					})->count();
				if($check > 0){
					DB::rollback();
					return 2;
				}
				if (count($data) > 0) {
					$query->update($data);
					if (!$query) {
						DB::rollback();
						return 3;
					}
				}
				if (count($data_relationship) > 0) {
					$query->m_device_translations_all()->where('language_id', $request->lang)->update($data_relationship);
					if (!$query) {
						DB::rollback();
						return 3;
					}
				}
            } else if($request->action == 'delete') {
				$noti = MNotification::where('device_id', $request->id);
				if(count($noti->get()) > 0) {
					DB::rollback();
					return 4;
				}
                $ref = MDeviceTranslation::where('translation_id', $request->id);
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
            } else if($request->action == 'insertlist') {
                $list_name = str_replace("\r\n", "\n", trim($request->listname));
                $list_name = explode("\n", trim($list_name));
                foreach($list_name as $key => $val){
                    if(!empty($val) && $val != ''){
                        $check = MDevice::whereHas('m_device_translations_all', function ($query_check) use ($request){
							$query_check->where('name', $request->name)->where('language_id', $request->lang);
						})->count();
                        if($check < 1){
                            $data_relationship['name'] = $val;
                        }
                        $query = MDevice::create($data);
						if(!$query) {
							DB::rollback();
							return 6;
						}
						
						$data_relationship['translation_id'] = $query->id;
						$trans = self::renderTrans($query->m_device_translations(), $data_relationship);
						if(!$trans) {
							DB::rollback();
							return 6;
						}
                    }
                }
            } else {
				$check = MDevice::whereHas('m_device_translations_all', function ($query_check) use ($request){
					$query_check->where('name', $request->name)->where('language_id', $request->lang);
				})->count();
				if($check > 0){
					DB::rollback();
					return 2;
				}
                $query = MDevice::create($data);
                if(!$query) {
                    DB::rollback();
                    return 6;
                }
                
                $data_relationship['translation_id'] = $query->id;
				$trans = self::renderTrans($query->m_device_translations(), $data_relationship);
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

	public function downloadClass($request, $language) {
		try {
			if($request->action == 'only') {
				$device = MDevice::with('m_device_translations', 'm_area.m_line.m_line_translations')
				->where('id', $request->id)->where('status', 1)->first();
				if($device) {
					$pdf = PDF::loadView('pdf.qrcode_only', ['data' => $device]);
					return $pdf->download('QR_'.$device->m_device_translations->name.'.pdf');
				} else {
					return false;
				}
			} else if($request->action == 'line') {
				$device = MDevice::with('m_device_translations', 'm_area.m_line.m_line_translations')
				->whereHas('m_area.m_line', function ($query) use ($request) {
					$query->where('id', $request->id);
				})->where('status', 1)->get();
				if(count($device) > 0) {
					$pdf = PDF::loadView('pdf.qrcode_line', ['data' => $device]);
					return $pdf->download('QR_Line_'.$device[0]->m_area->m_line->name.'.pdf');
				} else {
					return false;
				}
			} else {
				$device = MDevice::with('m_device_translations', 'm_area.m_line.m_line_translations')->where('status', 1)->get();
				if(count($device) > 0) {
					$pdf = PDF::loadView('pdf.qrcode', ['data' => $device]);
					return $pdf->download('QR_All_.pdf');
				}
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	}

    public function getClass($id, $language)
    {
        self::__construct();
        try {
            $data = MDevice::with('m_device_translations_all', 'm_area.m_line.m_section.m_site')
                    ->where('id', $id)
                    ->whereHas('m_device_translations_all', function ($query) use ($language) {
                        $query->where('language_id', $language);
                    })->first();
            $qrCode = QrCode::size(200)->generate($data->device_code);
            if (!empty($data)) {
                return self::JsonExport(200, trans('app.success'), ['data'=>$data, 'qrCode'=>$qrCode]);
            } else {
                return self::JsonExport(404, trans('app.error_404'));
            }
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }
    

    public function getDTClass($majorId = null, $courseId = null)
    {
        self::__construct();
        try {
			if($majorId != null && $majorId != 0){
				if($courseId != null && $courseId != 0){
					$data = Models\MClass::with('m_class_translations', 'm_course.m_course_translations', 'm_course.m_major.m_major_translations')
					->where('course_id', $courseId);
				} else {
					$data = Models\MClass::with('m_class_translations', 'm_course.m_course_translations', 'm_course.m_major.m_major_translations')
					->whereHas('m_course', function($query) use ($majorId){
						$query->where('major_id', $majorId);
					});
				}
			} else {
				$data = Models\MClass::with('m_class_translations', 'm_course.m_course_translations', 'm_course.m_major.m_major_translations');
			}
			return Datatables::of($data)
			->editColumn('name', function ($v) {
				if(!empty($v->m_class_translations->name)) {
					return '<span class="tx-name">' . $v->m_class_translations->name . '</span><div class="d-none"><div class="img-qr tx-center">';
				} else {
					return '';
				}
			})
			->filterColumn('name', function ($query, $keyword) {
				$query->whereHas('m_class_translations', function ($rs) use($keyword) {
						$rs->where('name', 'LIKE', '%'.$keyword.'%');
				});
			})
			->editColumn('major_name', function ($v) {
				if(!empty($v->m_course->m_major->m_major_translations->name)) {
						return '' . $v->m_course->m_major->m_major_translations->name . '';
				} else {
						return '';
				}
			})
			->editColumn('course_name', function ($v) {
				if(!empty($v->m_course->m_course_translations->name)) {
					return '' . $v->m_course->m_course_translations->name . '';
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

				if(1==1) {
					if($v->device_code != '' && $v->device_code != null && $v->status != 0){
						$action .=  '<a href="'.route('admin.location.machine.code.download.ajax').'?action=only&id='.$v->id.'" class="btn-action table-action-print cursor-pointer tx-info mg-l-5" data-lang="'.$this->lang_id.'" data-id="'.$v->id.'"><i class="fa fa-qrcode"></i></a>';
					}
				}
				return $action;
			})
			->addIndexColumn()
			->rawColumns(['action', 'status', 'name', 'course_name', 'major_name'])
			->make(true);
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }
    //DEMO
}
