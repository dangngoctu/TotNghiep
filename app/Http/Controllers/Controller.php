<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use \Spatie\Activitylog\Models\Activity;
use \Firebase\JWT\JWT;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Auth;
use Config;
use Vmorozov\FileUploads\FilesSaver as Uploader;
use Illuminate\Http\UploadedFile;
use App\Models;
use App\Models\ConfigLanguage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function instance($class)
    {
        try {
            $instantiator = new \Doctrine\Instantiator\Instantiator();
            $instance = $instantiator->instantiate($class);
            return $instance;
        } catch (\Exception $e) {
            return null;
        }
    }
}
