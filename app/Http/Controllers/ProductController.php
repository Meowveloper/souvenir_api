<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::get();
        return response()->json([
            'products' => $products
        ]);
    }


    //for product list page
    public function listWithCategories() {
        $products = Product::select('products.*', 'categories.name as category_name')->
        leftJoin('categories', 'categories.id', 'products.category_id')->get();

        $categories = Category::get();

        return response()->json([
            'products' => $products,

            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'instock' => $request->instock
        ];

        if (!empty($request->image)) {


            $imageName = uniqid() . '_meowveloper_' . $request->file('image')->getClientOriginalName();

            // $imageName = rtrim($imageName, '/');
            // $imageName = rtrim($imageName, '$');
            $request->file('image')->storeAs('public/productImages', $imageName);
        } else {
            $imageName = NULL;
        }
        $data['image'] = $imageName;

        Product::create($data);

        $products = Product::get();

        $autoSelectId = Product::where('name', '=', $request->name)->first()->id;

        return response()->json([
            'status' => 'success',
            'products' => $products,
            'autoSelectId' => $autoSelectId
        ]);
    }


    public function update(Request $request) {
        logger($request->toArray());
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->categoryId,
            'instock' => $request->instock
        ];

        if(!empty($request->image)) {
            $oldImage = Product::where('id', '=', $request->id)->first()->image;
            


            Storage::delete('public/productImages/' . $oldImage);



            $imageName = uniqid() . '_meowveloper_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/productImages', $imageName);
            $data['image'] = $imageName;
        }

        Product::where('id', '=', $request->id)->update($data);

        $product = Product::where('id', '=', $request->id)->first();

        return response()->json([
            'product' => $product
        ]);
    }

    public function delete(Request $request) {
        $oldImage = Product::where('id', '=', $request->id)->first()->image;

        Storage::delete('public/productImages/' . $oldImage);


        Product::where('id', '=', $request->id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
