<?php


namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryService
{
    public function getAll()
    {
        $categories=Category::all();
        return $categories;
    }

    public function store(CategoryRequest $request)
    {
        $category=Category::create([
            'name'=>$request->name,
        ]);

        return $category;
    }

    public function show($id)
    {
        $category=Category::find($id);

        if(is_null($category))
        {
            throw new HttpResponseException(response()->json('category not found',404));
        }

        return $category;
    }

    public function update(CategoryRequest $request,$id)
    {

        $category=Category::find($id);
        if(!$category)
        {
            throw new HttpResponseException(response()->json("not found",404));
        }

        $category->update($request->all());

        return $category;
    }

    public function destroy($id)
    {
        $category=Category::find($id);
        if(!$category)
        {
            throw new HttpResponseException(response()->json("not found",404));
        }
        $category->delete();

    }

}
