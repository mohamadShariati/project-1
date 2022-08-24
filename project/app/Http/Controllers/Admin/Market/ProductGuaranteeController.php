<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Guarantee;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class ProductGuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return view('admin.market.product.guarantee.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.market.product.guarantee.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Product $product)
    {
        $validated = $request ->validate([
            'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'price_increase' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);

        $inputs=$request->all();
        $inputs['product_id']=$product->id;

        $guarantee=Guarantee::create($inputs);
        return redirect()->route('admin.market.guarantee.index',$product->id)->with('swal-success','گارانتی جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Guarantee $guarantee)
    {
        $guarantee->delete();
        return redirect()->route('admin.market.guarantee.index',$product->id)->with('swal-success','گارانتی با موفقیت حذف شد');
    }
}
