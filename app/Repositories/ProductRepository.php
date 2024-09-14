<?php


namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class ProductRepository
{

    public function getAll()
    {
        return Product::all();
    }

    public function create($user,$request,$category_id)
    {
        return Product::create([
            'user_id'=>$user->id,
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'expiration_date'=>$request->expiration_date,
            'image_url'=>$request->image_url,
            'quantity'=>$request->quantity,
            'category_id'=>$category_id,

        ]);
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function productUser($id,$user_id)
    {
        return Product::query()
            ->where('id','=',$id)
            ->where('user_id','=',$user_id)->exists();
    }

    public function update($product,$request)
    {
        $product->update($request->all());
    }

    public function productUserf($id,$user_id)
    {
        return Product::query()
            ->where('id','=',$id)
            ->where('user_id','=',$user_id)->first();
    }

    public function sort($sort)
    {
        return Product::query()->orderBy($sort)->get();
    }

    public function categoryQue($request)
    {
        return Category::query()
            ->select('id')
            ->where('name','=', $request->category_name)
            ->first()['id'];
    }
}
