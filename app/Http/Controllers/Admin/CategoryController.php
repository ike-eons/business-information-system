<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'categories'    => $categories,
        ]);
    }

    

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|alpha_num|unique:categories|min:3',
            'description' => 'required'
        ]);

        $category = new Category();

        $category->name = $request['name'];
        $category->description = $request['description'];


        $category->save();

        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'category' => $category
        ]);
    }

    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($id);

        $this->validate($request, [
            'name'      =>  'required|unique:categories|alpha_num|max:191',
            'description' => 'required'
        ]);

        $input = $request->all();
        $targetCategory->update($input);

        return response()->json([
            'message' => 'category updated'
        ]);

    }

    public function delete($id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();

        return response()->json([
            'message' => 'category deleted'
        ]);  

    }
}
