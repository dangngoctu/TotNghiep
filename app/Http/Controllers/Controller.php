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

    static public function JsonExport($code, $msg, $data = null, $optinal = null)
    {
        try {
            $callback = [
                'code' => $code,
                'msg' => $msg
            ];
            if ($data != null) {
                $callback['data'] = $data;
            }else if(is_array($data) && count($data) == 0){
                $callback['data'] = array();
            } 
            else {
                $callback['data'] = (object)[];
            }
            if ($optinal != null && is_array($optinal)) {
                if (count($optinal) > 1) {
                    for ($i = 0; $i < count($optinal); $i++) {
                        $callback[$optinal[$i]['name']] = $optinal[$i]['data'];
                    }
                } else {
                    $callback[$optinal[0]['name']] = $optinal[0]['data'];
                }
            }
            return response()->json($callback, 200, []);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'msg' => 'Error'], 200, []);
        }
    }

    public function renderTrans($query, $data, $optional = null) {
        try {
            DB::beginTransaction();
            $config = new ConfigLanguage;
            $result = true;
            if($config->count() > 0) {
                foreach($config->get() as $k => $v) {
                    $data['language_id'] = $v->id;
                    if(!empty($optional)) {
                        $data['slug'] = $optional;
                    } else {
                        if(!empty($data['slug_name']) && !empty($data['slug_category']) && !empty($data['slug_prefix'])) {
                            $data['slug'] = self::slugify($data['slug_name'].'-'.$v->code, $data['slug_prefix']);
                        }
                    }
                    $trans = $query->create($data);
                    if(!$trans) {
                        $result = false;
                    }
                    if(empty($optional)) {
                        if(!empty($data['slug']) && !empty($data['slug_category'])) {
                            $new_slug = MSlug::create(['slug' => $data['slug'], 'category' => $data['slug_category']]);
                            if(!$new_slug) {
                                $result = false;
                            }
                        }
                    }
                }
            }
            if($result) {
                DB::commit();
                return true;
            } else {
                DB::rollback();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
