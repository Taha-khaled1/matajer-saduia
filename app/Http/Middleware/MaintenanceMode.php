<?php

namespace App\Http\Middleware;

use App\Models\Maintenance;
use App\Models\SettingWeb;
use Closure;
use Illuminate\Http\Request;

class MaintenanceMode 
{
  
    public function handle(Request $request, Closure $next)
    {
        $data= Maintenance::first();
        if ($data->ismaintenanc ==true) {
            $massg=app()->getLocale()=='ar'?'التطبيق في وضع الصيانه الان يرجي الزياره لاحقا':'The app is currently in maintenance mode please visit back later';
           return response()->json([
             'status_code' => 401,
             'message'=>   $massg,
           ],401);
        }
        return $next($request);
    }
}