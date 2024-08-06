<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService=$productService;
    }

    public function index(Request $request)
    {
        $products=$this->productService->index($request);
        return response()->json($products);
    }



    public function store(ProductRequest $request)
    {
        $product=$this->productService->store($request);
        return response()->json($product);
    }



    public function show($id)
    {
        $product=$this->productService->show($id);
        return response()->json($product);
    }



    public function update(ProductRequest $request,$id)
    {
        $product=$this->productService->update($request,$id);
        return response()->json($product);
    }



    public function destroy($id)
    {
        $this->productService->destroy($id);
        return response()->json("Successfully deleted");
    }

    public function sort(Request $request)
    {
        $sorting = $this->productService->sort($request);
        return response()->json($sorting);
    }
}
