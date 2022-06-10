@extends('admin.layouts.master')

@section('head-tag')
<title>نظرات</title>
@endsection

@section('content')
{{-- {{dd($comments)}} --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#"> خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#"> بخش محتوا</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> نظرات</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                 نظرات
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="#" class="btn btn-info btn-sm disabled">ایجاد نظر </a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کد کاربر</th>
                            <th>متن کامنت</th>
                            <th>پاسخ به </th>
                            <th> نویسنده نظر</th>
                            <th>کد پست</th>
                            <th>پست</th>
                            <th>دیدیه شده</th>
                            {{-- <th>موافقت شده</th> --}}
                            <th>وضعیت تایید</th>
                            <th>وضعیت کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $key => $comment)
                        <tr>
                            <th>{{$key+=1}}</th>
                            <th>{{$comment->author_id}}</th>
                            <td>{{Str::limit($comment->body,10)}}</td>
                            <td>{{$comment->parent_id ? Str::limit($comment->parent->body,10, '...')  :' '}} </td>
                            <td>{{$comment->user->FullName}} </td>
                            <td>{{$comment->commentable_id}}</td>
                            <td>{{$comment->commentable->title}}</td>
                            <td>
                                {{-- <input type="checkbox" @if ($comment->seen == 1 ) checked @endif> --}}
                            {{$comment->seen == 1 ? 'دیده شده' : 'دیده نشده'}}
                            </td>
                            <td>
                                {{-- <input type="checkbox" @if ($comment->approved == 1 ) checked @endif> --}}
                                {{$comment->approved == 1 ? 'تایید شده' : "تایید نشده"}}
                            </td>
                            {{-- <td>
                                <input type="checkbox">
                            </td> --}}
                            <td>
                                <input type="checkbox" id="{{$comment->id}}" onchange="changeStatus({{$comment->id}})" data-url="{{route('admin.content.comment.status',$comment->id)}}" @if ($comment->status == 1 ) checked @endif>
                            </td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.content.comment.show',$comment->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> نمایش</a>
                               {{-- @if ($comment->parent_id == null) --}}
                                @if($comment->approved == 1)
                                <a href="{{ route('admin.content.comment.approved', $comment->id)}} "class="btn btn-warning btn-sm" type="submit"><i class="fa fa-clock"></i> عدم تایید</a>
                                @else
                                <a href="{{ route('admin.content.comment.approved', $comment->id)}}" class="btn btn-success btn-sm text-white" type="submit"><i class="fa fa-check"></i>تایید</a>
                                @endif
                                {{-- @endif --}}
                            </td>
                        </tr>
                        @endforeach
                        
                       
                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection
@section('script')

    <script type="text/javascript">
        function changeStatus(id){
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url : url,
                type : "GET",
                success : function(response){
                    if(response.status){
                        if(response.checked){
                            element.prop('checked', true);
                            successToast('دسته بندی با موفقیت فعال شد')
                        }
                        else{
                            element.prop('checked', false);
                            successToast('دسته بندی با موفقیت غیر فعال شد')
                        }
                    }
                    else{
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error : function(){
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message){

                var successToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                        '<strong class="ml-auto">' + message + '</strong>\n' +
                        '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                            '<span aria-hidden="true">&times;</span>\n' +
                            '</button>\n' +
                            '</section>\n' +
                            '</section>';

                            $('.toast-wrapper').append(successToastTag);
                            $('.toast').toast('show').delay(5500).queue(function() {
                                $(this).remove();
                            })
            }

            function errorToast(message){

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                        '<strong class="ml-auto">' + message + '</strong>\n' +
                        '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                            '<span aria-hidden="true">&times;</span>\n' +
                            '</button>\n' +
                            '</section>\n' +
                            '</section>';

                            $('.toast-wrapper').append(errorToastTag);
                            $('.toast').toast('show').delay(5500).queue(function() {
                                $(this).remove();
                            })
            }
        }
    </script>

{{-- <script type="text/javascript">
    
    function approved(id){
        
        var element = $("#" + id + '-approved')
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');
        //   alert(element);
        $.ajax({
            url : url,
            type : "GET",
            success : function(response){
                if(response.status){
                    if(response.checked){
                        element.prop('checked', true);
                        successToast('کامنت  با موفقیت تایید شد')
                    }
                    else{
                        element.prop('checked', false);
                        successToast('تایید  با موفقیت غیر فعال شد')
                    }
                }
                else{
                    element.prop('checked', elementValue);
                    errorToast('هنگام ویرایش مشکلی بوجود امده است')
                }
            },
            error : function(){
                element.prop('checked', elementValue);
                errorToast('ارتباط برقرار نشد')
            }
        });

        function successToast(message){

            var successToastTag = '<section class="toast" data-delay="5000">\n' +
                '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                        '<span aria-hidden="true">&times;</span>\n' +
                        '</button>\n' +
                        '</section>\n' +
                        '</section>';

                        $('.toast-wrapper').append(successToastTag);
                        $('.toast').toast('show').delay(5500).queue(function() {
                            $(this).remove();
                        })
        }

        function errorToast(message){

            var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                        '<span aria-hidden="true">&times;</span>\n' +
                        '</button>\n' +
                        '</section>\n' +
                        '</section>';

                        $('.toast-wrapper').append(errorToastTag);
                        $('.toast').toast('show').delay(5500).queue(function() {
                            $(this).remove();
                        })
        }
    }
</script> --}}


@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])


@endsection
