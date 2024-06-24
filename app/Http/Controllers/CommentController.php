<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function index($product_id)
    {
        $product =  Product::find($product_id);
        $comments=$product->comments()->get();
        return response()->json($comments);
    }



    public function store(Request $request,Product $product)
    {
        $request->validate([
            'comment_text'=>['required','string'],
        ]);

        $user=Auth::user();

        $comment=$product->comments()->create([
            'comment_text'=>$request->comment_text,
            'user_id'=>$user->id

        ]);

        return response()->json($comment);
    }


    public function show($id)
    {
        $comment=Comment::find($id);

        if(is_null($comment))
        {
            return "comment not found";
        }
        return response()->json($comment);
    }



    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[
            'comment_text'=>['required','string'],

        ]);
        $user=Auth::user();

        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }
        $comment=Comment::where('id',$id)->where('user_id',$user->id)->first();
        if(!$comment)
        {
            return response()->json("not found",404);
        }

        $comment->comment_text=$request->comment_text;
        $comment->product_id=$id;
        $comment->update();
        return response()->json($comment);
    }


    public function destroy($comment_id)
    {
        $user=auth()->user();

        $comment = Comment::where('id',$comment_id)->where('user_id',$user->id)->first();

        if($comment){
            $comment->delete();
            return "Successfully deleted";
        }

        return response()->json('not found',404);


    }
}
