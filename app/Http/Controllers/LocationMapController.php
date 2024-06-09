<?php

namespace App\Http\Controllers;

use App\Models\LocationMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationMapController extends Controller
{
    public function get(Request $request)
    {
        $locationMaps = LocationMap::all();
        Log::info($locationMaps);

        return response()->json([
            'data' => $locationMaps
        ]);
//        return $locationMaps;
    }
}
