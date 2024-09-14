<?php


namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository=$categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryRepository->create($request);
    }

    public function show($id)
    {
        $category=$this->categoryRepository->getById($id);

        if(is_null($category))
        {
            throw new HttpResponseException(response()->json('category not found',404));
        }

        return $category;
    }

    public function update(CategoryRequest $request,$id)
    {

        $category=$this->categoryRepository->getById($id);
        if(!$category)
        {
            throw new HttpResponseException(response()->json("not found",404));
        }

        return $this->categoryRepository->update($category,$request);
    }

    public function destroy($id)
    {
        $category=$this->categoryRepository->getById($id);
        if(!$category)
        {
            throw new HttpResponseException(response()->json("not found",404));
        }
        $category->delete();

    }

}
