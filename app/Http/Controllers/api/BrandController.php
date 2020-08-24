<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();

        return response()->json([
            'brands' => $brands
        ]);
    }


    public function store(Request $request)
    {
        //validate brand data
        $request->validate([
            'name' =>  'required|unique:brands',
           
        ]);
        // $brand = new Brand();
        // $brand->name = $request->name;
        // $brand->save();
        $brand = Brand::create([
            'name' => $request['name'],
        ]);
        
        // $id = $brand->id;

        return ['message'=>'brand created','brand'=>$brand];
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        $brand->update($request->all());

        return ['message' => 'update'];
    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
