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
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models;
use Vmorozov\FileUploads\FilesSaver as Uploader;
use Illuminate\Http\UploadedFile;


class Setting extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $lang;
    protected $lang_id;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
        $this->lang_id = LaravelLocalization::getSupportedLocales()[$this->lang]['id'];
    }

    public function getSetting(){
        self::__construct();
        try {
            $data = Models\MSetting::where('id', 1)->first();
            if (!empty($data)) {
                return self::JsonExport(200, trans('app.success'), $data);
            } else {
                return self::JsonExport(404, trans('app.error_404'));
            }
        } catch (\Exception $e) {
            return self::JsonExport(404, trans('app.error_404'));
        }
    }

    public function postSetting($request){
        self::__construct();
        try {
            DB::beginTransaction();
            $setting = Models\MSetting::where('id',1);
            if(!$setting){
                DB::rollback();
                return false;
            }
            $data_trans = [];
            $data = [];
            if($request->has('limit_upload') && !empty($request->limit_upload)) {
                $data['limit_upload'] = $request->limit_upload;
            }
            if($request->has('phone') && !empty($request->phone)) {
                $data['phone'] = $request->phone;
            }
            if($request->has('default_password') && !empty($request->default_password)) {
                $data['default_password'] = $request->default_password;
            }
            if($request->has('logo') && !empty($request->logo)) {
                $dir = public_path('img/images_app');
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0777, true, true);
                }
                $name_image_logo = 'logo_'.time().'.'.$request->logo->getClientOriginalExtension();
                $data['logo'] = 'img/images_app/'.$name_image_logo;
            } else {
                if($request->fileListLogo == 0) {
                    $data['logo'] = null;
                }
            }
            if(count($data) >0){
                $setting->update($data);
                if(!$setting){
                    DB::rollback();
                    return false;
                }
            }
            DB::commit();
            if($request->has('logo') && !empty($request->logo)) {
                if(!empty($setting->logo)){
                    @unlink(public_path($setting->logo));
                }
                if(!empty($name_image_logo)) {
                    Uploader::uploadFile($request->logo, 'img/images_app', 'app', false, $name_image_logo);
                }
            }

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function getDTLogtime()
    {
        self::__construct();
        try {
            $data = Models\Logtime::with('m_user');
            return Datatables::of($data)
            ->editColumn('name', function ($v) {
                if(!empty($v->m_user->name)) {
                    return $v->m_user->name;
                } else {
                    return '';
                }
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('m_user', function ($rs) use($keyword) {
                    $rs->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->editColumn('timein', function ($v) {
                if(!empty($v->time_in)) {
                    return $v->time_in;
                } else {
                    return '';
                }
            })
            ->editColumn('timeout', function ($v) {
                if(!empty($v->time_out)) {
                    return $v->time_out;
                } else {
                    return '';
                }
            })
            ->addIndexColumn()
            ->rawColumns(['name', 'timein', 'timeout'])
            ->make(true);
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }
}