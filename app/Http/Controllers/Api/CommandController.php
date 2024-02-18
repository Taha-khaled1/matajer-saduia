<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function scheduleCommand()
    {
        try {

            Artisan::call('schedule:run');

            return response()->json(['message' => 'Command executed successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Command failed: ' . $e->getMessage()], 500);
        }
    }

}