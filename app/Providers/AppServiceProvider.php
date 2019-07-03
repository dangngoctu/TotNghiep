<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Validator;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use LaravelLocalization;
use App\Models;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Generator as UrlGenerator; 
use Jenssegers\Agent\Agent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Date::setLocale(\Session::get('locale'));
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $config_main = Models\MSetting::where('id', 1)->first();
            $agent = new Agent();
            if($agent->isDesktop()) {
                View::share('agent_detect', 'desktop');
            } else {
                View::share('agent_detect', 'mobile');
            }
            View::share('config_main', $config_main);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }
    }
}
