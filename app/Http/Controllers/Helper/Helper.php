<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Models;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;

class Helper extends Controller
{
    //
    public function admin_login_action($request){
        try{
            $throttler = Throttle::get($request, config('constant.limit_login'), config('constant.limit_time'));
            $credentials = [
                'phone' => $request->username,
                'password' => $request->password
            ];
            if(Auth::attempt($credentials)){
                if(Auth::user()->status == 1){
                    return 200;
                } else {
                    return 499;
                }
                // if(Auth::user()->can('admin_login')){
                    
                // } else {
                //     $throttler->hit();
                //     Auth::logout();
                //     DB::rollback();
                //     return 402;
                // }
            } else {
                $throttler->hit();
                // self::writelog('Login', 'Fail');
                return 402;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
