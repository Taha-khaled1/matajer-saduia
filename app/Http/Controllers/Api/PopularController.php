<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Popular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopularController extends Controller
{

    function index()
    {
        $populars = DB::table('populars')
            ->orderBy('views', 'desc')
            ->latest()
            ->limit(15)
            ->get();
        return response()->json([
            'keywords' => $populars,
            'message' => 'Success',
            'status_code' => 200,
        ], 200);
    }

public function keywordViews($keyword)
{
    $popular = Popular::where('keyword', $keyword)->first();

    if (!$popular) {
        $popular = new Popular();
        $popular->views = 1;
        $popular->keyword = $keyword;
    } else {
        $popular->views += 1;
    }

    $popular->save();

    return response()->json(['message' => 'Success', 'status_code' => 200], 200);
}
}