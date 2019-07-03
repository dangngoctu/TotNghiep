<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models;

class AdminController extends Controller
{
    //
    protected $instance;
    public function __construct()
	{
		$this->instance = $this->instance(\App\Http\Helper\Helper::class);
		// $this->lang = LaravelLocalization::getCurrentLocale();
    }
    
    public function admin_login(){
        try {
			if (Auth::check()) {
				// return redirect()->route('user.index');
			} else {
				return view('theme.admin.page.login');
			}
		} catch (\Exception $e) {
			return redirect()->route('home.login');
		}
    }
}
