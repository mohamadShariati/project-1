<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AnswerRequest;
use App\Models\Content\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unSeenComments = Comment::where('seen',0)->get();
        foreach ($unSeenComments as $unSeenComment){
            $unSeenComment -> seen = 1 ;
            $result = $unSeenComment->save();
        }

        $comments = Comment::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

        return view('admin.content.comment.show', compact('comment'));
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
    public function destroy($id)
    {
        //
    }

    public function status(Comment $comment)
    {
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();

        if ($result) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    //    public function approved(Comment $comment){
    //        dd('hi');
    //        $comment->approved = $comment->approved == 0 ? 1 : 0;
    //        $result = $comment->save();

    //        if ($result){
    //            return redirect()->route('admin.content.comment.index')->with('swal-success','تغییر وضعیت تایید با موفقیت انجام شد');

    //        } else {
    //            return redirect()->route('admin.content.comment.index')->with('swal-error','تغییر وضعیت تایید با مشکل مواجه شذ');
    //        }
    //    }

    public function approved(Comment $comment)
    {

        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();
        if ($result) {
            return redirect()->route('admin.content.comment.index')->with('swal-success', '  وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return redirect()->route('admin.content.comment.index')->with('swal-error', '  وضعیت نظر با خطا مواجه شد');
        }
    }

    public function answer(AnswerRequest $request, Comment $comment)
    {
        if ($comment -> parent_id == 0){

        $inputs = $request->all();

        $inputs['parent_id'] = $comment->id;
        $inputs['author_id'] = 1;  //موقت چون احراز نداریم
        $inputs['commentable_id'] = $comment->commentable_id;
        $inputs['commentable_type'] = $comment->commentable_type;
        $inputs['approved'] = 1;
        $inputs['status'] = 1;

        // $inputs = $comment->save();

        $result=Comment::create($inputs);
        return redirect()->route('admin.content.comment.index')->with('swal-success','پاسخ شما با موفقیت ثبت شد');
    }else{
        return redirect()->route('admin.content.comment.index')->with('swal-error','خطا');
    }
    }
}
