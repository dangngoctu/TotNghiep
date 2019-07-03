<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Storage;

class Blacklist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if(empty($request->header('Authorization'))) {
                return self::JsonExport(405, trans('app.expire_section'));
            }
            $token = str_replace("Bearer ","", $request->header('Authorization'));
            $check = Storage::disk('blacklist')->exists(md5($token));
            if($check) {
                return self::JsonExport(405, trans('app.expire_section'));
            }
            return $next($request);
        } catch (\Exception $e) {
            return self::JsonExport(405, trans('app.expire_section'));
        }
    }

    static public function JsonExport($code, $msg)
    {
        $callback = [
            'code' => $code,
            'msg' => $msg
        ];
        return response()->json($callback, 200, [], JSON_NUMERIC_CHECK);
    }

}
