@extends('blog.layout')
@section('content')


<div class="container section-title" style="margin-bottom:0px;margin-top:10px;" data-aos="fade-up">
  <div class="section-title-container d-flex align-items-center justify-content-between" style="padding-bottom:0px;">
    <h2>아이디/비밀번호 찾기</h2>
    <p>아이디를 찾거나 비밀번호를 초기화 할 수 있습니다.</p>
  </div>
</div>
<!-- End Section Title -->

<div class="container">
  <div class="row">
    <div class="col-lg-12" style="padding-top: 50px">

      <main class="form-signin w-50 m-auto">
      <form method="post" action="/loginok">
        @csrf
      <div style="text-align:center;">

      </div>
        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="email" placeholder="아이디(이메일)을 입력하세요." value="{{ old('email') }}">
          <label for="floatingInput">아이디(이메일)</label>
        </div>
        <br>
        <div class="alert alert-primary" id="truemsg" style="display:none;" role="alert"></div>
        <div class="alert alert-danger" id="failmsg" style="display:none;" role="alert"></div>
        <button class="w-100 btn btn-lg btn-primary" type="button" id="passid">비밀번호 초기화 하기</button>

      </form>
      </main>

    </div>
    {{-- @include('blog.classroomside') --}}
    </div>
    </div>
    <script>
        $("#passid").click(function () {
            var username=$("#username").val();
            if(!username){
                alert('이름을 입력하세요.');
                return false;
            }
            var data = {
                username : username
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('auth.finduserid') }}',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if(data.result==true){
                        $("#failmsg").hide();
                        $("#truemsg").show();
                        $("#truemsg").text(data.msg);
                    }else{
                        $("#truemsg").hide();
                        $("#failmsg").show();
                        $("#failmsg").text(data.msg);
                    }
                },
                error: function(data) {
                console.log("error" +JSON.stringify(data));
                }
            });
        });
        
    </script>
@endsection