<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
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
            $countries = Country::all();
           return response()->json([
                'status_code' => 200,
                'message' =>  "Success",               
                'countries' =>$countries ,

            ], 200);
        } catch (\Throwable $e) {
             return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => 500], 500);
        }
    }
}