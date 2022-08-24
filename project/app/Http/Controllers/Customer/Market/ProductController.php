<?php

namespace App\Http\Controllers\Customer\Market;

use Illuminate\Http\Request;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product(Product $product)
    {

        $relatedProducts=Product::all();
        return view('customer.market.product.product',compact('product','relatedProducts'));
    }

    public function addToFavorite(Product $product)
    {
       if(Auth::check())
       {
        $product->user()->toggle([Auth::user()->id]);
        if($product->user->contains(Auth::user()->id)){
            return response()->json(['status' => 1]);
        }
        else{
            return response()->json(['status' => 2]);
        }
       }
       else{
        return response()->json(['status' => 3]);
       }
    }

    
}
