<?php


namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function create($request)
    {
        return Category::create([
            'name'=>$request->name,
        ]);
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function update($category,$request)
    {
        return $category->update($request->all());
    }
}
