<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository=$productRepository;
    }

    public function index(Request $request)
    {
        if($request->all() == null)
            return $this->productRepository->getAll();

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

        $category_id = $this->productRepository->categoryQue($request);

        $user = Auth::user();

        $product=$this->productRepository->create($user,$request,$category_id);

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
        $product=$this->productRepository->getById($id);

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
        $product= $this->productRepository->productUser($id,$user_id);
        if($product==null){
            throw new HttpResponseException(response()->json("not found",404));
        }

        $product=$this->productRepository->getById($id);
        $this->productRepository->update($product,$request);

        return $product;
    }



    public function destroy($id)
    {
        $user_id=Auth::id();
        $product= $this->productRepository->productUserf($id,$user_id);
        if(!$product){
            throw new HttpResponseException(response()->json("not found",404));
        }
        $product->delete();
    }

    public function sort(Request $request)
    {
        $sort=$request->sort;
        $sorting =  $this->productRepository->sort($sort);
        return $sorting;
    }

}
