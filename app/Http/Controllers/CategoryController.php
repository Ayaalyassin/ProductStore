<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;


class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService=$categoryService;
    }
    public function index()
    {
        $categories=$this->categoryService->getAll();
        return response()->json($categories);
    }


    public function store(CategoryRequest $request)
    {
        $category=$this->categoryService->store($request);

        return response()->json($category);
    }


    public function show($id)
    {
        $category=$this->categoryService->show($id);

        return response()->json($category);
    }



    public function update(CategoryRequest $request,$id)
    {
        $category=$this->categoryService->update($request,$id);

        return response()->json($category);
    }


    public function destroy($id)
    {
        $this->categoryService->destroy($id);
        return response()->json("Successfully deleted");
    }
}
