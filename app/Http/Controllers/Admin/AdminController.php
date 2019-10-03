<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Exports\ExportLogtime;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    //
    protected $instance;
    public function __construct()
	{
		$this->instance = $this->instance(\App\Http\Controllers\Helper\Helper::class);
		$this->lang = LaravelLocalization::getCurrentLocale();
	}
	
	public function admin_error(Request $request)
	{
		return view('theme.admin.page.error');
	}
    
    public function admin_login(){
        try {
			if (Auth::check()) {
				return redirect()->route('home.index');
			} else {
				return view('theme.admin.page.login');
			}
		} catch (\Exception $e) {
			return redirect()->route('login');
		}
    }

    public function admin_login_action(Request $request){
        $rules = array(
			'username' => 'required|min:1|max:128',
			'password' => 'required|min:1|max:128',
		);
        $validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
            return self::JsonExport(403, "Vui lòng kiểm tra lại thông tin");
            
		} else {
            try {
                $action = $this->instance->admin_login_action($request);
                if($action == false){
                    return self::JsonExport(500, "Vui lòng kiểm tra lại thông tin");
                } else if ($action == 402) {
                    return self::JsonExport(402, "Vui lòng kiểm tra lại thông tin");
                } else if($action == 200) {
                    return self::JsonExport(200, "Đăng nhập thành công");
                } else if($action == 499) {
                    return self::JsonExport(200, "Tài khoản tạm thời bị khóa!");
                }
            } catch (\Exception $e) {
                return self::JsonExport(500, "Vui lòng kiểm tra lại thông tin");
            }
        }
    }

    public function logout(){
        try {
			if(Auth::user()) {
				Auth::logout();
            }
			session()->flush();
			return redirect()->route('login');
		} catch (\Exception $e) {
			return redirect()->route('login');
		}
    }

    public function index(){
        try {
			$user = Auth::user();
            return view('theme.admin.page.homepage')->with(['user' => $user]);
        } catch (\Exception $e) {
			return redirect()->route('login');
		}
    }

	//Category
    public function admin_category()
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_category') && Auth::user()->hasRole('admin')){
					return view('theme.admin.page.category');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

    public function admin_category_ajax(Request $request)
	{
		try {
            $instance = self::instance(\App\Http\Controllers\Helper\Category::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getCategory($request->id, $request->lang);
			}
			return $data = $instance->getDTCategory();
		} catch (\Exception $e) {
			return self::JsonExport(500, 'Vui lòng thử lại');
		}
    }
    
    public function admin_post_category_ajax(Request $request)
	{
		$rules = array(
			'name' => 'min:1|max:255',
			'action' => 'required|in:insert,update,delete',
			'description' => 'required|min:1|max:255',
		);
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = self::instance(\App\Http\Controllers\Helper\Category::class);
				$data = $instance->postCategory($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update category', trans('app.success'));
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert category', trans('app.success'));
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete category', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Update info category', 'Fail');
					return self::JsonExport(403, 'Vui lòng kiểm tra lại thông tin');
				}
			} catch (\Exception $e) {
				self::writelog('Update info category', $e->getMessage());
				return self::JsonExport(500, trans('app.error_500'));;
			}
		}
	}
	
	//Failure mode
	public function admin_fail_mode()
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_failure') && Auth::user()->hasRole('admin')){
					return view('theme.admin.page.fail_mode');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_fail_mode_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\FailureMode::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getFailureMode($request->id);
			}
			if($request->has('categoryId') && !empty($request->categoryId)) {
				return $data = $instance->getDTFailureMode($request->categoryId);
			}
			return $data = $instance->getDTFailureMode();
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_fail_mode_ajax(Request $request)
	{
		$rules = array(
			'category_id' => 'digits_between:1,10',
			'name' => 'min:1|max:255',
			'action' => 'required|in:insert,update,delete',
		);
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\FailureMode::class);
				$data = $instance->postFailureMode($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update failure mode', trans('app.success'));
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert failure mode', trans('app.success'));
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete failure mode', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Delete failure mode', trans('app.success'));
					return self::JsonExport(403, 'Vui lòng kiểm tra lại thông tin');
				}
			} catch (\Exception $e) {
				// self::writelog('Update info failure mode', $e->getMessage());
				return self::JsonExport(500, 'Vui lòng kiểm tra lại thông tin');;
			}
		}
	}

	//Failure mode detail
	public function admin_fail_mode_detail()
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_failure_detail') && Auth::user()->hasRole('admin')){
					return view('theme.admin.page.fail_mode_detail');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_fail_mode_detail_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\FailureModeDetail::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getFailureModeDetail($request->id, $request->lang);
			}
			return $data = $instance->getDTFailureModeDetail();
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_fail_mode_detail_ajax(Request $request)
	{
		$rules = array(
			'falure_id' => 'digits_between:1,10',
			'weight_factor' => 'required|digits_between:1,10',
			'name' => 'min:1|max:255',
			'action' => 'required|in:insert,update,delete',
		);
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\FailureModeDetail::class);
				$data = $instance->postFailureModeDetail($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update failure mode detail', trans('app.success'));
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert failure mode detail', trans('app.success'));
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete failure mode detail', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Update info failure mode detail', 'Failing');
					return self::JsonExport(403, 'Vui lòng kiểm tra thông tin');
				}
			} catch (\Exception $e) {
				self::writelog('Update failure mode detail', $e->getMessage());
				return self::JsonExport(500, 'Vui lòng kiểm tra thông tin');;
			}
		}
	}

	//Line
	public function admin_line()
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_line') && Auth::user()->hasRole('admin')){
					return view('theme.admin.page.line');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_line_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\Line::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getLine($request->id, $request->lang);
			}
			return $data = $instance->getDTLine();
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_line_ajax(Request $request)
	{
		$rules = array(
			'name' => 'min:1|max:255',
			'action' => 'required|in:insert,update,delete',
		);
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\Line::class);
				$data = $instance->postLine($request);
				if ($data === true) {
//					self::writelog('Update group category', trans('app.success'));
					switch ($request->action) {
						case 'update':
							// self::writelog('Update Site/Location', trans('app.success'));
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert Site/Location', trans('app.success'));	
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete Site/Location', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Edit info Site/Location', 'Fail');
					return self::JsonExport(403, trans('app.error_403'));

				}
			} catch (\Exception $e) {
				// self::writelog('Update group category', $e->getMessage());
				return self::JsonExport(500, 'Vui lòng kiểm tra lại thông tin');
			}
		}
	}

	//Area
	public function admin_area()
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_area') && Auth::user()->hasRole('admin')){
					return view('theme.admin.page.area');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_area_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\Area::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getArea($request->id, $request->lang);
			}
			if($request->has('lineId') && !empty($request->lineId)) {
				return $data = $instance->getDTArea($request->lineId);
			}
			return $data = $instance->getDTArea();
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_area_ajax(Request $request)
	{
		$rules = array(
			'action' => 'required|in:insert,update,delete,insertlist',
			'line_id' => 'digits_between:1,10'
		);
		if($request->action == 'insertlist') {
			$rules['listname'] = 'required';
		} else {
			$rules['name'] = 'required|max:255';
		}
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\Area::class);
				$data = $instance->postArea($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update area', trans('app.success'));
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert area', trans('app.success'));
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete area', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Update info area', 'Fail');

					return self::JsonExport(403, 'Vui lòng kiểm tra lại thông tin');
				}
			} catch (\Exception $e) {
				// self::writelog('Update info area', $e->getMessage());
				return self::JsonExport(500, 'Vui lòng kiểm tra lại thông tin');
			}
		}
	}

	//Device
	public function admin_device(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_machine')){
					return view('theme.admin.page.device');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_device_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\DeviceController::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getDevice($request->id, $request->lang);
			}
			if($request->has('lineId') && !empty($request->lineId)) {
				if($request->has('areaId') && !empty($request->areaId)) {
					return $data = $instance->getDTDevice($request->lineId, $request->areaId);
				}
				return $data = $instance->getDTDevice($request->lineId);
			}
			return $data = $instance->getDTDevice();
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_device_ajax(Request $request)
	{
		$rules = array(
			'area_id' => 'digits_between:1,10',
			'action' => 'required|in:insert,update,delete,insertlist',
		);
		if($request->action == 'insertlist') {
			$rules['listname'] = 'required';
		} else {
			$rules['name'] = 'required|max:255';
		}
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, trans('app.error_403'));
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\DeviceController::class);
				$data = $instance->postDevice($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update machine', 'Cập nhật thành công');
							return self::JsonExport(200, 'Cập nhật thành công');
						case 'insert':
							// self::writelog('Insert machine', trans('app.success'));
							return self::JsonExport(200, 'Thêm mới thành công');
						default:
							// self::writelog('Delete machine', trans('app.success'));
							return self::JsonExport(200, 'Xóa thành công');
					}
				} else {
					// self::writelog('Update info machine', 'Fail');
					return self::JsonExport(403, 'Vui lòng thử lại');
					
				}
			} catch (\Exception $e) {
				self::writelog('Update info machine', $e->getMessage());
				return self::JsonExport(500, 'Vui lòng thử lại');
			}
		}
	}

	//user
	public function admin_user(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_user')){
					return view('theme.admin.page.user');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_user_ajax(Request $request)
	{
		try {
			$instance = $this->instance(\App\Http\Controllers\Helper\User::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getUser($request->id, $request->lang);
			}
			if($request->has('log_id') && !empty($request->log_id)) {
				return $data = $instance->getDTUserActivities($request->log_id);
			}
			return $data = $instance->getDTUser($request->lineId);
		} catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
		}
	}

	public function admin_post_user_ajax(Request $request)
	{
		$rules = array(
			'phone' => 'required|min:1|max:20|unique:m_user',
			// 'password' => 'required|min:1|max:128',
			'name' => 'min:1|max:128',
			'action' => 'required|in:insert,update,delete',
			'dob' => 'required|before:18 years ago',
			'avatar' => 'max:3000|mimes:png,jpg,jpeg',
		);
		if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
			$rules['password'] = 'min:0|max:128';
			$rules['phone'] = 'required|min:1|max:20|unique:m_user,phone,'.$request->id;
		} else if($request->action == 'delete' || $request->action == 'deactive' || $request->action == 'active') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, $validator->errors());
		} else {
			try {
				$instance = $this->instance(\App\Http\Controllers\Helper\User::class);
				$data = $instance->postUser($request);
				if ($data === true) {
					switch ($request->action) {
						case 'update':
							// self::writelog('Update user', trans('app.success'));
							return self::JsonExport(200, trans('app.success'));
						case 'insert':
							// self::writelog('Insert user', trans('app.success'));
							return self::JsonExport(200, trans('app.success'));
						case 'deactive':
							// self::writelog('Deactive user', trans('app.success'));
							return self::JsonExport(200, trans('app.success'));
						case 'active':
							// self::writelog('Active user', trans('app.success'));
							return self::JsonExport(200, trans('app.success'));
						default:
							// self::writelog('Delete user', trans('app.success'));
							return self::JsonExport(200, trans('app.success'));
					}
				} else {
					// self::writelog('Edit info user', 'Fail');
					switch ($data) {
						case 1:
							return self::JsonExport(403, trans('app.error_404'));
						case 2:
							return self::JsonExport(403, trans('app.error_403'));
						case 3:
							return self::JsonExport(403, trans('app.update_fail'));
						case 4:
							return self::JsonExport(403, trans('app.delete_fail'));
						case 5:
							return self::JsonExport(403, trans('app.delete_fail'));
						case 6:
							return self::JsonExport(403, trans('app.add_fail'));
						default:
							return self::JsonExport(403, trans('app.error_403'));
					}
				}
			} catch (\Exception $e) {
				self::writelog('Edit info user', $e->getMessage());
				return self::JsonExport(500, trans('app.error_500'));;
			}
		}
	}

	//Role

	public function admin_role(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_role')){
					return view('theme.admin.page.role');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_role_ajax(Request $request){
        try {
            $instance = $this->instance(\App\Http\Controllers\Helper\Role::class);
            if($request->has('id') && !empty($request->id)) {
                return $data = $instance->getRole($request->id);
            }
            return $data = $instance->getDTRole();
        } catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
        }
	}
	
	public function admin_post_role_ajax(Request $request){
        $rules = array(
            'display_name' => 'required|max:191',
            'description' => 'required|max:191',
            'action' => 'required|in:insert,update,delete'
        );
        if($request->action == 'update') {
			$rules['id'] = 'required|digits_between:1,10';
		} else if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		} else if($request->action == 'insert') {
			$rules['name'] = 'required|max:191';
		}
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, trans('app.error_403'));
        } else {
            try {
                $instance = $this->instance(\App\Http\Controllers\Helper\Role::class);
                $action = $instance->postRole($request);
                if ($action === true){
                    if($request->action == 'update'){
                        // self::writelog('Update data role', trans('app.success'));
                        return self::JsonExport(200, trans('app.success'));
                    }else if($request->action == 'insert'){
                        // self::writelog('insert data role', trans('app.success'));
                        return self::JsonExport(200, trans('app.success'));
                    } else{
                        // self::writelog('Delete data role', trans('app.success'));
                        return self::JsonExport(200, trans('app.success'));
                    }
                }else {
                    // self::writelog('Update data role', 'Fail');
                    switch ($action) {
                        case 1:
                            return self::JsonExport(403, trans('app.error_404'));
                        case 2:
                            return self::JsonExport(403, trans('app.error_403'));
                        case 3:
                            return self::JsonExport(403, trans('app.update_fail'));
                        case 4:
                            return self::JsonExport(403, trans('app.delete_fail'));
                        case 5:
                            return self::JsonExport(403, trans('app.delete_fail'));
                        case 51:
                            return self::JsonExport(403, trans('app.delete_fail'));
                        case 6:
                            return self::JsonExport(403, trans('app.add_fail'));
                        case 8:
                            return self::JsonExport(403, trans('app.error_403'));
                        default:
                            return self::JsonExport(403, trans('app.error_403'));
                    }
                }
            } catch (\Exception $e) {
                // self::writelog('Update data role', $e->getMessage());
                return self::JsonExport(500, trans('app.error_500'));
            } 
        }
	}
	
	public function get_permission(){
        try {
            $instance = $this->instance(\App\Http\Controllers\Helper\Role::class);
            return $action = $instance->get_permission();
            
        } catch (\Exception $e) {
            return self::JsonExport(500, trans('app.error_500'));
        } 
	}

	//Setting
	public function admin_setting(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_setting')){
					return view('theme.admin.page.setting');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_setting_ajax(Request $request){
        try {
            $instance = $this->instance(\App\Http\Controllers\Helper\Setting::class);
            $data = $instance->getSetting();
            return $data;
        } catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
        }  
	}
	
	public function admin_post_setting_ajax(Request $request){

        $rules = array(
            'logo' => 'max:3000|mimes:png,jpg,jpeg',
            'limit_upload' => 'required|numeric|min:1|max:10',
            'phone' => 'required|max:20|min:0',
            'default_password' => 'required|max:20'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, trans('app.error_403'));
        } else {
            try {
                $instance = $this->instance(\App\Http\Controllers\Helper\Setting::class);
				$action = $instance->postSetting($request);
                if ($action === true){
                    return self::JsonExport(200, trans('app.success'));
                }else {
                    // self::writelog('Update info setting', 'Fail');
                    return self::JsonExport(403, trans('app.error_403'));
                }
            } catch (\Exception $e) {
                // self::writelog('Update info setting', $e->getMessage());
                return self::JsonExport(500, trans('app.error_500'));
            } 
        }
	}

	//Notification
	
	public function admin_notification(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_notification')){
					return view('theme.admin.page.notification');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_notification_ajax(Request $request){
        try {
            $instance = $this->instance(\App\Http\Controllers\Helper\Notification::class);
            if($request->has('id') && !empty($request->id)) {
                return $data = $instance->getNotification($request->id,$request->lang);
            }
            return $data = $instance->getDTNotification();
        } catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
        }
	}

	public function admin_post_notification_add_ajax(Request $request){

        $rules = array(
            'logo' => 'max:3000|mimes:png,jpg,jpeg',
			'device_id' => 'required|numeric',
			'category_id' => 'required|numeric',
			'failure_id' => 'required|numeric',
            'comment' => 'required|max:255',
		);
		if($request->action == 'delete') {
			$rules = array('id' => 'required|digits_between:1,10');
		}
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, 'Error');
        } else {
            try {
                $instance = $this->instance(\App\Http\Controllers\Helper\Notification::class);
				$action = $instance->postAddNotification($request);
                if ($action === true){
                    return self::JsonExport(200, 'Success');
                }else {
                    // self::writelog('Update info setting', 'Fail');
                    return self::JsonExport(403, 'Error');
                }
            } catch (\Exception $e) {
                // self::writelog('Update info setting', $e->getMessage());
                return self::JsonExport(500, 'Error');
            } 
        }
	}

	public function admin_post_notification_update_ajax(Request $request){

        $rules = array(
			'id' => 'required|numeric',
            'status' => 'required|numeric',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, 'Error');
        } else {
            try {
                $instance = $this->instance(\App\Http\Controllers\Helper\Notification::class);
				$action = $instance->postUpdateNotification($request);
                if ($action === true){
                    return self::JsonExport(200, 'Success');
                }else {
                    // self::writelog('Update info setting', 'Fail');
                    return self::JsonExport(403, 'Error');
                }
            } catch (\Exception $e) {
                // self::writelog('Update info setting', $e->getMessage());
                return self::JsonExport(500, 'Error');
            } 
        }
	}
	
	public function change_pass(Request $request){
		$rules = array(
			'oldPassword' => 'required|min:1|max:255',
			'newPassword' => 'required|min:6|max:255',
			'renewPassword' => 'required|min:6|max:255|same:newPassword'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return self::JsonExport(403, 'Error');
		} else {
			try{
				DB::beginTransaction();
				$account = Models\MUser::find(Auth::user()->id);
				if($account){
					if(Hash::check($request->oldPassword,$account->password)){
						$account->update(['password' =>  Hash::make($request->newPassword)]);
						if(!$account){
							DB::rollback();
							return self::JsonExport(403, 'Error');
						}
					} else {
						DB::rollback();
						return self::JsonExport(403, 'Error');
					}
				} else {
					DB::rollback();
					return self::JsonExport(403, 'Error');
				}
				DB::commit();
				return self::JsonExport(200, 'Success');
			} catch (\Exception $e) {
				DB::rollback();
				return self::JsonExport(500, 'Error');
			}
		}
	}

	public function admin_logtime(Request $request)
	{
		try {
			if(Auth::user()) {
				if(Auth::user()->can('admin_logtime')){
					return view('theme.admin.page.logtime');
				} else {
					return redirect()->guest(route('admin.error'));
				}
			} else {
				return redirect()->guest(route('home.login'));
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
		}
	}

	public function admin_logtime_ajax(Request $request){
        try {
            $instance = $this->instance(\App\Http\Controllers\Helper\Setting::class);
            return $data = $instance->getDTLogtime();
        } catch (\Exception $e) {
			return self::JsonExport(500, trans('app.error_500'));
        }
	}

	public function exportlogtime(Request $request){
		try{
			return Excel::download(new ExportLogtime($request->fromDate, $request->toDate),'Logtime-'.Carbon::parse($request->fromDate)->format('Ymd').'-'.Carbon::parse($request->toDate)->format('Ymd').'.xlsx');
		} catch (\Exception $e) {
			return self::JsonExport(500, 'Error');
        }
	}

	public function admin_report(Request $request){
		try{
			$data = self::getReport($request);
			if($data === false){
                return redirect()->guest(route('admin.error'));
            } else {
                return view('theme.admin.page.report',['data' => $data]);
            }
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
        }
	}

	public function getReport($request){
		try{
			$logtime = self::getReportLogtime();
			$userPerformance = self::getUserPerformance();
			$totalNotification = self::getNotification();
			$totalUser = self::getUser();
			$totalMachine = self::getMachine();
			$machine_no_noti = self::getMachineNoNoti();
			return json_decode(json_encode([
                'logtime' => $logtime,
				'performance' => $userPerformance,
				'notification' => $totalNotification,
				'total_user' => $totalUser,
				'total_machine' => $totalMachine,
				'machine_no_noti' => $machine_no_noti,
            ]));
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getReportLogtime(){
		try{
			$logtimedate = Models\Logtime::where('user_id', '!=', 1)->where('created_at', '>=', Carbon::now()->startOfMonth()->startOfDay())->get();
			$late = 0;
			$early = 0;
			foreach($logtimedate as $key => $val){
				if(Carbon::parse($val->time_in)->format('Hi') > 830){
					$late++;
				}
				if(Carbon::parse($val->time_out)->format('Hi') < 1730){
					$early++;
				}
			}
			$logtime = ['late' => $late, 'early' => $early];
			return $logtime;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getUserPerformance(){
		try{
			$list_user = Models\MUser::where('status', 1)->where('id', '!=', 1)->whereHas('role_users', function($query){
				$query->whereNotIn('role_id', [1,2]);
			})->get();
			$user_performance = [];
			for($i = 0; $i < 12; $i++){
				$user_performance[$i] = [];
				$user_performance[$i]['time'] = Carbon::now()->subMonths($i)->startOfMonth()->startOfDay();
				if(count($list_user) > 0){
					foreach($list_user as $key => $val){
						$user = Models\MUser::where('status', 1)->where('id', $val->id)->first(); 
						if($user->hasRole('owner')){
							$area_management = Models\SystemManagement::where('user_id', $val->id)->pluck('area_id');
							$list_device = Models\MDevice::where('status', 1)->whereIn('area_id', $area_management)->pluck('id');
						} elseif($user->hasRole('manager')){
							$line_management = Models\SystemManagement::where('user_id', $val->id)->pluck('line_id');
							$area_management = Models\MArea::where('status', 1)->whereIn('line_id', $line_management)->pluck('id');
							$list_device = Models\MDevice::where('status', 1)->whereIn('area_id', $area_management)->pluck('id');
						}
						$notification = Models\MNotificaiton::where('status', 2)->whereIn('device_id', $list_device)
						->where('created_at', '>=', Carbon::now()->subMonths($i)->startOfMonth()->startOfDay())
						->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth()->endofDay())
						->count();
						$user_performance[$i]['performance'][$key] = ['id' => $val->id, 'name' => $val->name, 'performance' => 100-$notification];
					}
				}
			}
			return $user_performance;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getNotification(){
		try{
			$num_noti = [];
			for($i = 1; $i < 12; $i++){
				$list_notification = Models\MNotificaiton::where('status', 2)->whereNull('deleted_at')
				->where('created_at', '>=', Carbon::now()->subMonths($i)->startOfMonth()->startOfDay())
				->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth()->endofDay())
				->count();
				$num_noti[$i] = ['count' => $list_notification, 'time' => Carbon::now()->subMonths($i)->startOfMonth()->startOfDay()];
			}
			return $num_noti;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getUser(){
		try{
			$user = [];
			for($i = 0; $i < 12; $i++){
				$num_user = Models\MUser::where('status', 1)->where('id', '!=', 1)->whereNull('deleted_at')
				->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth()->endofDay())
				->count();
				$user[$i] = ['time' => Carbon::now()->subMonths($i)->endOfMonth()->endofDay(),
							 'count' => $num_user
							];
			}
			return $user;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getMachine(){
		try{
			$machine = [];
			for($i = 0; $i < 12; $i++){
				$num_machine = Models\MDevice::where('status', 1)->whereNull('deleted_at')
				->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth()->endofDay())
				->count();
				$machine[$i] = ['count' => $num_machine, 'time' => Carbon::now()->subMonths($i)->endOfMonth()->endofDay()];
			}
			return $machine;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function getMachineNoNoti(){
		try{
			$list_notification = Models\MNotificaiton::where('status', 2)->whereNull('deleted_at')
			->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth()->startOfDay())
			->where('created_at', '<=', Carbon::now()->subMonth()->endOfMonth()->endofDay())->pluck('device_id');
			$list_device = Models\MDevice::with('m_device_translations','m_area.m_area_translations','m_area.m_line.m_line_translations')
			->where('status', 1)->whereNull('deleted_at')
			->whereNotIn('id',$list_notification )->get();
			return $list_device;
		} catch (\Exception $e) {
			return false;
        }
	}

	public function admin_report_new(Request $request){
		try {
			switch ($request->type) {
				case 'late':
				case 'early':
					return view('theme.admin.page.comelate');
				case 'performance':
					return view('theme.admin.page.performance');
				case 'machine':
					return view('theme.admin.page.machine');
			}
		} catch (\Exception $e) {
			return redirect()->guest(route('admin.error'));
        }
	}

	public function report_user(Request $request){
		$rules = array(
            'month' => 'required|numeric',
            'tag' => 'required|in:early,late'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, trans('app.error_403'));
        } else {
			try {
				$result = [];
				$list_user = Models\MUser::where('id', '!=', 1)->where('status', 1)->whereNull('deleted_at')->get();
				foreach($list_user as $key => $val){
					$count_logtime = Models\Logtime::where('user_id', '!=', 1)->where('user_id', $val->id)
					->where('created_at', '>=', Carbon::now()->subMonths($request->month)->startOfMonth()->startOfDay())
					->where('created_at', '<=', Carbon::now()->subMonths($request->month)->endOfMonth()->endOfDay());
					if($request->tag == 'early'){
						$count_logtime->where('time_out', '<' , date('Y-m-d').' 17:30:00');
					} else {
						$count_logtime->where('time_in', '>' , date('Y-m-d').' 08:30:00');
					}
					$count_logtime = $count_logtime->count();
					array_push($result, ['id' => $val->id, 'name' => $val->name, 'time' => $count_logtime]);
				}
			return self::JsonExport(200, trans('app.success'), $result);
			} catch (\Exception $e) {
				return redirect()->guest(route('admin.error'));
			}
		}
	}

	public function report_performance(Request $request){
		$rules = array(
            'month' => 'required|numeric',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, 'False');
        } else {
			try {
				$result = [];
				$user = Models\MUser::with('role_users')->where('status', 1)->whereNull('deleted_at')->where('id', '!=', 1)->whereHas('role_users', function($query){
					$query->whereNotIn('role_id', [1,2]);
				})->get();
				foreach($user as $key => $val) {
					$user = Models\MUser::where('status', 1)->where('id', $val->id)->first(); 
					if($user->hasRole('owner')){
						$area_management = Models\SystemManagement::where('user_id', $val->id)->pluck('area_id');
						$list_device = Models\MDevice::where('status', 1)->whereIn('area_id', $area_management)->pluck('id');
					} elseif($user->hasRole('manager')){
						$line_management = Models\SystemManagement::where('user_id', $val->id)->pluck('line_id');
						$area_management = Models\MArea::where('status', 1)->whereIn('line_id', $line_management)->pluck('id');
						$list_device = Models\MDevice::where('status', 1)->whereIn('area_id', $area_management)->pluck('id');
					}
					$notification = Models\MNotificaiton::where('status', 2)->whereIn('device_id', $list_device)
						->where('created_at', '>=', Carbon::now()->subMonths($request->month)->startOfMonth()->startOfDay())
						->where('created_at', '<=', Carbon::now()->subMonths($request->month)->endOfMonth()->endofDay())
						->count();
					array_push($result, ['id' => $val->id, 'name' => $val->name, 'performance' => 100-$notification]);
				}
				return self::JsonExport(200, trans('app.success'), $result);
			} catch (\Exception $e) {
				return redirect()->guest(route('admin.error'));
			}
		}
	}
}
