<?php

namespace App\Http\Controllers\admin\notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Models\Notify\SMS;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(jalaliDate('today'));
        $sms = SMS::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.notify.sms.index', compact('sms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.notify.sms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SMSRequest $request)
    {
        $inputs=$request->all();

        $realTimeStampStart=substr($request->published_at,0,10);
        $inputs['published_at']=date("Y-m-d H:i:s",(int)$realTimeStampStart);

        $sms=SMS::create($inputs);
        return redirect()->route('admin.notify.sms.index')->with('swal-success','پیامک شما با موفقیت ثبت شد');
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
    public function destroy(SMS $SMS)
    {
        $result = $SMS->delete();
        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'حدف با موفقیت انجام شد');
    }

    public function status(SMS $SMS)
    {
        $SMS->status = $SMS->status == 0 ? 1 : 0;
        $result = $SMS->save();

        if ($result) {
            if ($SMS->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
