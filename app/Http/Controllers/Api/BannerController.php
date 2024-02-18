<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
          $banners = Banner::orderBy('arrange')->get();

           return response()->json([
                'status_code' => 200,
                'message' => 'Success',               
                'banners' =>$banners ,

            ], 200);
        } catch (\Throwable $e) {
             return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }
}