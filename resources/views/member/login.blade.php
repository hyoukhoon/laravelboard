@extends('blog.layout')
@section('content')


<div class="container section-title" style="margin-bottom:0px;margin-top:10px;" data-aos="fade-up">
  <div class="section-title-container d-flex align-items-center justify-content-between" style="padding-bottom:0px;">
    <h2>로그인</h2>
    <p>로그인 페이지입니다.</p>
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
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
          <label for="floatingInput">아이디(이메일)</label>
        </div>
        <br>
        <div class="form-floating">
          <input type="password" name="passwd" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">암호</label>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="1" name="remember"> Remember me
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">로그인</button>
        <br>
        <a href="/idfind"><button class="w-100 btn btn-lg btn-warning" type="button">아이디/비밀번호 찾기</button></a>
      </form>
      </main>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif
      @if(Session::has('loginFail'))
        <script type="text/javascript" >
          alert("{{ session()->get('loginFail') }}");
        </script>
      @endif

    </div>
    {{-- @include('blog.classroomside') --}}
    </div>
    </div>
@endsection