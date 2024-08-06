<?php


namespace App\Services;


use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentService
{
    public function index($product_id)
    {
        $product =  Product::find($product_id);
        if(!$product)
            throw new HttpResponseException(response()->json("not found",404));
        $comments=$product->comments()->get();
        return $comments;
    }

    public function store($request,Product $product)
    {

        $user=Auth::user();

        $comment=$product->comments()->create([
            'comment_text'=>$request->comment_text,
            'user_id'=>$user->id

        ]);

        return $comment;
    }

    public function show($id)
    {
        $comment=Comment::find($id);

        if(is_null($comment))
        {
            throw new HttpResponseException(response()->json("not found",404));
        }
        return $comment;
    }



    public function update($request,$id)
    {
        $user=Auth::user();

        $comment=$user->comments()->find($id);
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

        $comment=$user->comments()->find($comment_id);

        if(!$comment)
            throw new HttpResponseException(response()->json("not found",404));
        $comment->delete();


    }

}
