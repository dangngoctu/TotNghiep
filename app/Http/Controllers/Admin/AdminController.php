<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models;
use Validator;

class AdminController extends Controller
{
    //
    protected $instance;
    public function __construct()
	{
		$this->instance = $this->instance(\App\Http\Controllers\Helper\Helper::class);
		// $this->lang = LaravelLocalization::getCurrentLocale();
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
}
