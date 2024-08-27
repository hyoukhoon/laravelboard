@extends('blog.layout')
@section('content')
<?php

        if($id){
            $pid=$id;
            $btitle = "수정";
        }else{
            $pid=time();
            $btitle = "쓰기";
        }
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
  
          <div class="col-lg-12">
  
            <!-- Comment Form Section -->
            <section id="comment-form" class="comment-form section">
              <div class="container">
                <form method="post" action="/classcreate" enctype="multipart/form-data" style="padding-top:20px;"> 
                <input type="hidden" name="pid" id="pid" value="{{ $pid }}">
                <input type="hidden" name="id" id="bid" value="{{ $id }}">
                <input type="hidden" name="code" id="code" value="{{ $code }}"> 
                  <h4>강의실에 강좌 올리기</h4>
                  {{-- <p style="float:right;">좋은 글을 남깁니다.</p> --}}
                  <div class="row">
                    <div class="col form-group">
                      <select class="form-select" name="cate" id="cate" aria-label="Default select example">
                        <option value="1" <?php if($cls->cate==1){echo "selected";}?>>인터넷 기초부터 시작하는 PHP 프로그래밍</option>
                        <option value="2" <?php if($cls->cate==2){echo "selected";}?>>html부터 시작하는 PHP 프로그래밍</option>
                        <option value="3" <?php if($cls->cate==3){echo "selected";}?>>쉽고 재밌게 시작하는 PHP 프로그래밍</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <input name="subject" id="subject" type="text" class="form-control" placeholder="제목을 입력하세요." value="{{ $cls->subject }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <input name="tags" id="tags" type="text" class="form-control" placeholder="태그를 ,로 구분해서 입력하세요." value="{{ $cls->tags }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <textarea name="shorts" id="shorts" class="form-control" placeholder="간단한 설명글을 입력해주세요.리스트에 표시됩니다.">{{ $cls->shorts }}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                        <iframe id="summerframe" src="{{ route('blog.summernote',['code' => $code, 'id' => $id]) }}" style="width:100%; height:700px; border:none" scrolling = "no"></iframe>
                    </div>
                  </div>
  
                  <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="sendsubmit()">{{ $btitle }}</button>
                  </div>
  
                </form>
  
              </div>
            </section><!-- /Comment Form Section -->
  
          </div>
  
          {{-- @include('blog.classroomside') --}}

      </div>
<script>
    function sendsubmit(){
        var subject=$("#subject").val();
        //var content=$("#content").val();
        var content=$('#summerframe').get(0).contentWindow.$('#summernote').summernote('code');//iframe에 있는 값을 가져온다
        var pid = $("#pid").val();
        var code = $("#code").val();
        var tags = $("#tags").val();
        var shorts = $("#shorts").val();
        var cate = $("#cate option:selected").val();
        var data = {
            subject : subject,
            content : content,
            pid : pid,
            code : code,
            tags : tags,
            shorts : shorts,
            cate : cate
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

    function updatesubmit(){
        var subject=$("#subject").val();
        //var content=$("#content").val();
        var content=$('#summerframe').get(0).contentWindow.$('#summernote').summernote('code');//iframe에 있는 값을 가져온다
        var bid='{{ $bid }}';
        var data = {
            subject : subject,
            content : content,
            bid : bid
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.update') }}',
            dataType: 'json',
            enctype: 'multipart/form-data',
            data: data,
            success: function(data) {
                location.href='/boards/show/'+data.bid+'/1';
            },
            error: function(data) {
                console.log("error" +data);
            }
        });
    }
</script>      
@endsection  