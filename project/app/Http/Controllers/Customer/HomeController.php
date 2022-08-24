<?php

namespace App\Http\Controllers\Customer;

use App\Models\Market\Brand;
use Illuminate\Http\Request;
use App\Models\Content\Banner;
use App\Models\Market\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){
       
       
        // Auth::loginUsingId(2);
        
        $slideShowBanners = Banner::where('position',0)->where('status',1)->get();
        $topBanners = Banner::where('position',1)->where('status',1)->take(2)->get();
        $middleBanners = Banner::where('position',2)->where('status',1)->take(2)->get();
        $bottomBanners = Banner::where('position',3)->where('status',1)->take(1)->get();

        $brands = Brand::all();

        $mostVisitedProducts = Product::latest()->take(10)->get();
        // dd($mostVisitedProducts);

        $offerProducts = Product::latest()->take(10)->get();

        return view('customer.home',compact('slideShowBanners','topBanners','middleBanners','bottomBanners','brands','mostVisitedProducts','offerProducts'));
    }

    
}
