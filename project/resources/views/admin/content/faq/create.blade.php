@extends('admin.layouts.master')

@section('head-tag')
<title>دسته بندی</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">سوالات متداول</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد سوال</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ایجاد سوال
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.faq.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form id="form" action="{{route('admin.content.faq.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6">
                             <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select name="status" class="form-control" aria-label="Default select example">
                                    
                                    <option value="0" @if (old('status')== 0) selected @endif>غیر فعال</option>
                                    <option value="1" @if (old('status')== 1) selected @endif>فعال</option>
                                  </select>
                             </div>
                             @error('status')
                                 <span>
                                     <strong>
                                         {{$message}}
                                     </strong>
                                 </span>
                             @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="tags">تگ ها</label>
                                <input name="tags" value="{{old('tags')}}" class="form-control form-control-sm" type="hidden" id="tags">
                                <select class="select2 form-control form-control-sm" id="select_tags" multiple></select>
                            </div>
                            @error('tags')
                                <span>
                                    <strong class="alert-required text-danger">
                                        {{$message}}
                                    </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <div class="form-group">
                                <label for="">پرسش</label>
                                <input type="text" value="{{old('question')}}" class="form-control form-control-sm" name="question" id="question">
                                
                            </div>
                            @error('question')
                                <strong class="alert-required text-danger">
                                  <strong>
                                      {{$message}}
                                  </strong>
                                </strong>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">پاسخ</label>
                                <textarea name="answer" id="answer"  class="form-control form-control-sm" rows="6">{{old('answer')}}</textarea>
                            </div>
                            @error('answer')
                                <span class="alert-required text-danger">
                                   <strong>
                                       {{$message}}
                                   </strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('answer');
        // CKEDITOR.replace('question');
    </script>

    <script>
        $(document).ready(function () {
            var tags_input = $('#tags');
            var select_tags = $('#select_tags');
            var default_tags = tags_input.val();
            var default_data = null;

            if(tags_input.val() !== null && tags_input.val().length > 0)
            {
                default_data = default_tags.split(',');
            }

            select_tags.select2({
                placeholder : 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data
            });
            select_tags.children('option').attr('selected', true).trigger('change');


            $('#form').submit(function ( event ){
                if(select_tags.val() !== null && select_tags.val().length > 0){
                    var selectedSource = select_tags.val().join(',');
                    tags_input.val(selectedSource)
                }
            })
        })
    </script>

@endsection