<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list() {
        $categories = Category::get();
        return response()->json([
            'categories' => $categories
        ]);
    }

    public function create(Request $request) {
        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $categories = Category::get();
        $autoSelectId = Category::where('name', '=', $request->name)->first()->id;

        return response()->json([
            'categories' => $categories,
            'autoSelectId' => $autoSelectId
        ]);
    }
}
