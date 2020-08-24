<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'categories' => $categories
        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'description'   => 'required'
        ]);

        $category = Category::create($request->all());

        return ['message'=>'brand created',
                'category'=>$category
            ];
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description'   =>  'required'
        ]);

        $category->update($request->all());

        return response()->json([
            'message'   => 'category updated'
        ],400);

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
