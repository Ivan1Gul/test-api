<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function get(Request $request)
    {
        $categories = Category::with('business.businessTypes')->get();
        Log::info($categories);

        return response()->json([
            'data' => $categories
        ]);
    }
}
