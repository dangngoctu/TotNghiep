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
}
