@extends('boards.layout')
@section('content')
<section class="vh-100" style="background-color: #e3e4e6;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">
          <h1 class="mb-4" style="text-align:center;">회원가입</h1>
          <div class="card" style="border-radius: 15px;">
            <div class="card-body">
              <div class="row align-items-center pt-4 pb-3">
                <div class="col-md-3 ps-5">
                  <h6 class="mb-0">이름(닉네임)</h6>
                </div>
                <div class="col-md-9 pe-5">
                  <input type="text" name="name" id="name" class="form-control form-control-lg" />
                  <br>
                  <span id="namemsg"></span>
                </div>
              </div>
              <hr class="mx-n3">
              <div class="row align-items-center py-3">
                <div class="col-md-3 ps-5">
                  <h6 class="mb-0">이메일</h6>
                </div>
                <div class="col-md-9 pe-5">
                  <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="example@example.com" /><br>
                  <span id="emailmsg"></span>
                </div>
              </div>
              <hr class="mx-n3">
              <div class="row align-items-center py-3">
                <div class="col-md-3 ps-5">
                  <h6 class="mb-0">비밀번호</h6>
                </div>
                <div class="col-md-9 pe-5">
                    <input type="password" name="password1" id="password1" class="form-control form-control-lg" />
                </div>
              </div>
              <hr class="mx-n3">
              <div class="row align-items-center py-3">
                <div class="col-md-3 ps-5">
                  <h6 class="mb-0">비밀번호 확인</h6>
                </div>
                <div class="col-md-9 pe-5">
                    <input type="password" name="password2" id="password2" class="form-control form-control-lg" />
                </div>
              </div>
              @if ($errors->any())
              <div class="row align-items-center py-3">
                <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                  </ul>
                </div>
              </div>
              @endif
              <hr class="mx-n3">
              <div class="px-5 py-4" style="text-align:center;">
                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" id="signup">가입하기</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    $("#signup").click(function () {
		    var name=$("#name").val();
        var email=$("#email").val();
        var password1=$("#password1").val();
        var password2=$("#password2").val();
        // if(!name || !email || !password1 || !password2){
        //   alert('필수값을 입력해주세요.');
        //   return false;
        // }
        // if(password1!=password2){
        //   alert('비밀번호를 다시 확인해 주십시오.');
        //   return false;
        // }
        var data = {
          name : name,
          email : email,
          password : password1
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('auth.signupok') }}',
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data.result==true){
                    alert(data.msg);
                    location.href='/boards';
                }else{
                    alert(data.msg);
                    return false;
                }
            },
            error: function(data) {
            console.log("error" +JSON.stringify(data));
            }
        });
    });

    $("#email").on("keyup", function() {
        var email=$("#email").val();
        var data = {
            email : email
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('auth.emailcheck') }}',
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data.result==true){
                    $("#emailmsg").html("<font color='blue'>"+data.msg+"</font>");
                }else{
                    $("#emailmsg").html("<font color='red'>"+data.msg+"</font>");
                }
            },
            error: function(data) {
            console.log("error" +JSON.stringify(data));
            }
        });
    });
  </script>
@endsection  
