<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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

        return response()->json('done');

    }



}
