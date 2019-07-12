<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use GuzzleHttp\Client;
use App\Http\Helper\User\Polygon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Auth;
use Carbon\Carbon;
use \stdClass;
use Vmorozov\FileUploads\FilesSaver as Uploader;
use App\Models;
use Illuminate\Http\UploadedFile;

class Role extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $lang;
    protected $lang_id;

    public function __construct()
    {
        $this->lang = LaravelLocalization::getCurrentLocale();
        $this->lang_id = LaravelLocalization::getSupportedLocales()[$this->lang]['id'];
    }

    public function getDTRole(){
        self::__construct();
        try {
            $data = Models\Role::where('name', '!=', 'admin')->get();
            return Datatables::of($data)
            ->editColumn('id', function ($v){
                return $v->id;
            })
            ->editColumn('role', function ($v){
                return $v->name;
            })
            ->editColumn('name', function ($v){
                return $v->display_name;
            })
            ->editColumn('description', function ($v){
                return $v->description;
            })
            ->editColumn('action', function ($v){
                $action = ''; 
                $action .=' <span class="btn-action table-action-edit cursor-pointer tx-success" data-id="' . $v->id. '"><i' .
                            ' class="fa fa-edit"></i></span>' ;
                // $action .=  ' <span class="btn-action table-action-delete cursor-pointer tx-danger mg-l-5" data-id="' . $v->id. '"><i' .
                // 			' class="fa fa-trash"></i></span>';
                return $action;
            })
            ->rawColumns(['id','role','name','description','action'])
            ->make(true);
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        }
    }

    public function getRole($request){
        self::__construct();
        try {
            $data = Models\Role::with('permissions')->where('id', $request)->first();
            if (!empty($data)) {
                return self::JsonExport(200, trans('app.success'), $data);
            } else {
                return self::JsonExport(404, trans('app.error_404'));
            }
        } catch (\Exception $e) {
            return self::JsonExport(404, trans('app.error_404'));
        }
    }

    public function postRole($request){
        self::__construct();
        try {
            DB::beginTransaction();
            if($request->action == 'update' || $request->action == 'delete') {
                $query = Models\Role::find($request->id);
                if(!$query) {
                    DB::rollback();
                    return 1;
                }
            }
            $data = [];
            $check = 0;
            if($request->has('display_name') && !empty($request->display_name)) {
                $data['display_name'] = $request->display_name;
            }
            if($request->has('description') && !empty($request->description)) {
                $data['description'] = $request->description;
            }
            if($request->multiple_management == 'on') {
                $data['multiple_management'] = 1;
            } else {
                $data['multiple_management'] = 0;
            }
						$data_permission = [];
            if($request->has('permission') && $request->permission != '') {
                if(strpos($request->permission, ',') !== false) {
                    $permission = explode(',', $request->permission);
                    foreach($permission as $key => $val){
                        array_push($data_permission, $val);
                    }
                    $data_permission = array_unique($data_permission);
                } else {
										array_push($data_permission, $request->permission);
										$data_permission = array_unique($data_permission);
                }
            }
            if($request->action == 'update'){
                $query->update($data);
                $permission_role = Models\PermissionRole::where('role_id', $query->id);
                if(count($permission_role->get()) >0){
                    $permission_role->delete();
                    if(!$permission_role) {
                        DB::rollback();
                        return 3;
                    }
                }
                foreach ($data_permission as $key => $value) {
                    $query->attachPermission($value);
                }
                if(!$query) {
                    DB::rollback();
                    return 3;
                }
                $check = 1;
            } else if($request->action == 'insert'){
                if($request->has('name') && !empty($request->name)) {
                    $data['name'] = $request->name;
                }
                $query = Models\Role::create($data);
                if($query) {
                    foreach ($data_permission as $key => $value) {
                        $query->attachPermission($value);
                    }
                    if(!$query){
                        DB::rollback();
                        return 6;
                    }
                }else{
                    DB::rollback();
                    return 6;
                }
                $check = 1;
            } else {
                if($query->name == 'manager'){
                    DB::rollback();
                    return 51;
                }
                $count = Models\RoleUser::where('role_id', $query->id)->count();
                if($count > 0){
                    DB::rollback();
                    return 4;
                }
                Models\PermissionRole::where('role_id', $query->id)->delete();
                $query->delete();
                if(!$query) {
                    DB::rollback();
                    return 5;
                } 
                $check = 1;
            }
            if($check == 1){
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
}