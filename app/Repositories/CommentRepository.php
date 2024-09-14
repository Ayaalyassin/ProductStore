<?php


namespace App\Repositories;


use App\Models\Comment;
use App\Models\Product;

class CommentRepository
{

    public function getAll($product)
    {
        return $product->comments()->get();
    }

    public function getProduct($product_id)
    {
        return Product::find($product_id);
    }

    public function create($product,$request,$user)
    {
        return $product->comments()->create([
            'comment_text'=>$request->comment_text,
            'user_id'=>$user->id
        ]);
    }

    public function getById($id)
    {
        return Comment::find($id);
    }

    public function getComment($user,$id)
    {
        return $user->comments()->find($id);
    }

    public function delete($comment)
    {
        $comment->delete();
    }
}
