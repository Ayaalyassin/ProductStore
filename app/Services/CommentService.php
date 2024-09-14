<?php


namespace App\Services;

use App\Models\Product;
use App\Repositories\CommentRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository=$commentRepository;
    }

    public function index($product_id)
    {
        $product =  $this->commentRepository->getProduct($product_id);
        if(!$product)
            throw new HttpResponseException(response()->json("not found",404));
        return $this->commentRepository->getAll($product);
    }

    public function store($request,Product $product)
    {

        $user=Auth::user();

        return $this->commentRepository->create($product,$request,$user);
    }

    public function show($id)
    {
        $comment=$this->commentRepository->getById($id);

        if(is_null($comment))
        {
            throw new HttpResponseException(response()->json("not found",404));
        }
        return $comment;
    }



    public function update($request,$id)
    {
        $user=Auth::user();

        $comment=$this->commentRepository->getComment($user,$id);
        if(!$comment)
        {
            throw new HttpResponseException(response()->json("not found",404));
        }

        $comment->comment_text=$request->comment_text;
        $comment->product_id=$id;
        $comment->update();
        return $comment;
    }


    public function destroy($comment_id)
    {
        $user=auth()->user();

        $comment=$this->commentRepository->getComment($user,$comment_id);

        if(!$comment)
            throw new HttpResponseException(response()->json("not found",404));
        $this->commentRepository->delete($comment);


    }

}
