<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService
{

    public function index(Request $request)
    {
        if($request->all() == null)
            return Product::all();

        if($request->searchType == 'categoryName') {
            $request->searchData = Category::where('name', '=', $request->searchData)->get()[0]['id']; //category id
            $request->searchType = 'category_id';

            // name or expiredate                           // value
            return Product::query()->where($request->searchType, '=', $request->searchData)->get();

        }
        return null;

    }



    public function store(Request $request)
    {

        $category_id = Category::query()
            ->select('id')
            ->where('name','=', $request->category_name)
            ->first()['id'];

        $user = Auth::user();

        $product=Product::create([
            'user_id'=>$user->id,
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'expiration_date'=>$request->expiration_date,
            'image_url'=>$request->image_url,
            'quantity'=>$request->quantity,
            'category_id'=>$category_id,

        ]);

        foreach($request->list_discounts as $discount)
        {
            $product->discounts()->create([
                'date'=>$discount['date'],
                'discount_value'=>$discount['discount_value'],
            ]);
        }
        return $product;
    }



    public function show($id)
    {
        $product=Product::find($id);

        $product->increment('views');

        if(is_null($product))
        {
            throw new HttpResponseException(response()->json("not found",404));
        }
        $maxdiscount=null;

        if(!is_null($maxdiscount))
        {
            $discount_value=($product->price * $maxdiscount['discount_value'])/100;
            $product['current_price']=$product->price-$discount_value;
        }

        return $product;
    }



    public function update(Request $request,$id)
    {
        $user_id=Auth::id();
        $product= Product::query()
            ->where('id','=',$id)
            ->where('user_id','=',$user_id)->exists();
        if($product==null){
            throw new HttpResponseException(response()->json("not found",404));
        }

        $category_id = Category::query()
            ->select('id')
            ->where('name','=', $request->category_name)
            ->first()['id'];

        $product=Product::find($id);
        $product->update($request->all());

        return $product;
    }



    public function destroy($id)
    {
        $user_id=Auth::id();
        $product= Product::query()
            ->where('id','=',$id)
            ->where('user_id','=',$user_id)->first();
        if(!$product){
            throw new HttpResponseException(response()->json("not found",404));
        }
        $product->delete();
    }

    public function sort(Request $request)
    {
        $sort=$request->sort;
        $sorting =  Product::query()->orderBy($sort)->get();
        return $sorting;
    }

}
