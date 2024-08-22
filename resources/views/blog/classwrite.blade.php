@extends('blog.layout')
@section('content')
<?php

        $pid=time();
        $code="classroom";
    ?>
<!-- Page Title -->
    {{-- <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
          <h1 class="mb-2 mb-lg-0">Single Post</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.html">Home</a></li>
              <li class="current">Single Post</li>
            </ol>
          </nav>
        </div>
      </div><!-- End Page Title --> --}}

      <!-- Section Title -->
    <div class="container section-title" style="margin-bottom:0px;margin-top:10px;" data-aos="fade-up">
        <div class="section-title-container d-flex align-items-center justify-content-between" style="padding-bottom:0px;">
            <h2>강의실</h2>
            <p>개발자가 직접 알려주는 PHP 강의실입니다.</p>
        </div>
    </div>
    <!-- End Section Title -->
  
      <div class="container">
        <div class="row">
  
          <div class="col-lg-8">
  
            <!-- Comment Form Section -->
            <section id="comment-form" class="comment-form section">
              <div class="container">
                <form method="post" action="/classcreate" enctype="multipart/form-data" style="padding-top:20px;"> 
                <input type="hidden" name="pid" id="pid" value="{{ $pid }}">
                <input type="hidden" name="bid" id="bid" value="">
                <input type="hidden" name="code" id="code" value="{{ $code }}"> 
                  <h4>강의실에 강좌 올리기</h4>
                  {{-- <p style="float:right;">좋은 글을 남깁니다.</p> --}}
                  <div class="row">
                    <div class="col form-group">
                      <input name="subject" id="subject" type="text" class="form-control" placeholder="제목을 입력하세요.">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                        <iframe id="summerframe" src="{{ route('blog.summernote',['code' => $code]) }}" style="width:100%; height:600px; border:none" scrolling = "no"></iframe>
                    </div>
                  </div>
  
                  <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="sendsubmit()">등록</button>
                  </div>
  
                </form>
  
              </div>
            </section><!-- /Comment Form Section -->
  
          </div>
  
          @include('blog.classroomside')

      </div>
<script>
    function sendsubmit(){
        var subject=$("#subject").val();
        //var content=$("#content").val();
        var content=$('#summerframe').get(0).contentWindow.$('#summernote').summernote('code');//iframe에 있는 값을 가져온다
        var pid = $("#pid").val();
        var code = $("#code").val();
        var data = {
            subject : subject,
            content : content,
            pid : pid,
            code : code
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('classroom.classcreate') }}',
            dataType: 'json',
            enctype: 'multipart/form-data',
            data: data,
            success: function(data) {
                location.href='/classview/'+data.bid+'/1';
            },
            error: function(data) {
                console.log("error" +data);
            }
        });
    }
</script>      
@endsection  