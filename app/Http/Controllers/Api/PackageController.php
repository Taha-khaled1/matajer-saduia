<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index()
    {
        $packages = Package::all();
        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'packages' => $packages,
        ], 200);
    }
}
