<?php


namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function store($id)
    {
        $product=Product::find($id);
        if($product->likes()->where('user_id',Auth::id())->exists()){
            $product->likes()->where('user_id',Auth::id())->delete();
        }

        else{
            $product->likes()->create([
                'user_id'=>Auth::id()
            ]);
        }

    }


}
