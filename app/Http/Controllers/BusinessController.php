<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{
    public function get(Request $request)
    {
        $businesses = Business::with('business.businessTypes')->get();
        Log::info($businesses);

        return response()->json([
            'data' => $businesses
        ]);
    }
    public function getById(Request $request, $id)
    {
        $business = Business::with('businessTypes')->where('bs_id',$id)->first();
        Log::info($business);

        return response()->json([
            'data' => $business
        ]);
    }
}
