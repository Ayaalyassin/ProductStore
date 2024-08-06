<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Product;
use App\Services\CommentService;


class CommentController extends Controller
{

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService=$commentService;
    }

    public function index($product_id)
    {
        $comments=$this->commentService->index($product_id);
        return response()->json($comments);
    }



    public function store(CommentRequest $request,Product $product)
    {
        $comment=$this->commentService->store($request,$product);

        return response()->json($comment);
    }


    public function show($id)
    {
        $comment=$this->commentService->show($id);
        return response()->json($comment);
    }



    public function update(CommentRequest $request,$id)
    {
        $comment=$this->commentService->update($request,$id);
        return response()->json($comment);
    }


    public function destroy($comment_id)
    {
        $this->commentService->destroy($comment_id);
        return response()->json("Successfully deleted");
    }
}
