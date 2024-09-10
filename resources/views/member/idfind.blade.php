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
          <input type="text" name="username" class="form-control" id="floatingInput" placeholder="이름(닉네임)을 입력하세요." value="{{ old('username') }}">
          <label for="floatingInput">이름(닉네임)</label>
        </div>
        <br>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="1" name="remember"> Remember me
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="button">아이디 찾기</button>
      </form>
      </main>

    </div>
    {{-- @include('blog.classroomside') --}}
    </div>
    </div>
@endsection