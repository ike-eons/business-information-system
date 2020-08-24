<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  
    public function index()
    {
        $products = Product::latest()->get();

        return response()->json([
            'products'  => $products
        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'name'              => 'required|unique:products',
            'weight'            => 'required',
            'carton_quantity'   => 'required|numeric',
            'sales_price'       =>  'required',
            'stock_price'       =>  'required'
        ]);

        $product = Product::create($request->all());

        //add product to inventory
        DB::table('inventories')->insert([
            'product_id'    =>  $product['id'],
            'available_quantity'    => 0,
            'available_amount'      =>  0.00,
        ]);

        return response()->json([
            'message'   => 'product created and added to inventory',
            'product'   =>  $product,
        ],200);
    }

    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id'       => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'name'              => 'required',
            'weight'            => 'required',
            'carton_quantity'   => 'required|numeric',
            'sales_price'       =>  'required',
            'stock_price'       =>  'required'
        ]);

        $product->update($request->all());
        return response()->json([
            'message'   => 'product updated',
            'product'   => $product,
        ],400);
        

    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::table('inventories')->where('product_id', $id)->delete();

        $product->delete();

        return response()->json([
            'message'   => 'product deleted'
        ],200);
    }
}
