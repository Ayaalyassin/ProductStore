<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories=Category::all();
        return response()->json($categories);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string'],

        ]);

        $category=Category::create([
            'name'=>$request->name,
        ]);

        return response()->json($category);
    }


    public function show($id)
    {
        $category=Category::find($id);

        if(is_null($category))
        {
            return "category not found";
        }

        return response()->json($category);
    }



    public function update(Request $request, Category $category,$id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>['required','string'],
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }
        $category=Category::find($id);
        if(!$category)
        {
            return response()->json("not found",404);
        }

        $category->update($request->all());


        return response()->json($category);
    }


    public function destroy($id)
    {
        $category=Category::find($id);
        if(!$category)
        {
            return response()->json("not found",404);
        }
        $category->delete();
        return "Successfully deleted";
    }
}
