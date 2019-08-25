<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models;
use Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdminController extends Controller
{
    //
    protected $instance;
    public function __construct()
	{
		$this->instance = $this->instance(\App\Http\Controllers\Helper\Helper::class);
		$this->lang = LaravelLocalization::getCurrentLocale();
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
		// try {
            $instance = self::instance(\App\Http\Controllers\Helper\Category::class);
			if($request->has('id') && !empty($request->id)) {
				return $data = $instance->getCategory($request->id, $request->lang);
			}
			return $data = $instance->getDTCategory();
		// } catch (\Exception $e) {
		// 	return self::JsonExport(500, 'Vui lòng thử lại');
		// }
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
}
