@extends('boards.layout')

@section('header')
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <span class="fs-4">게시판 글쓰기</span>
        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        @guest()
            <a href="{{route('auth.login')}}" class="text-xl">로그인</a> / 
            <a href="{{route('auth.signup')}}" class="text-xl">회원가입</a>
        @endguest
        @auth()
            <form action="/logout" method="post" class="inline-block">
                @csrf
                <span class="text-xl text-blue-500">{{auth()->user()->userid}}</span> / 
                <a href="/logout"><button class="text-xl">로그아웃</button></a>
            </form>
        @endauth
        </nav>
    </div>
@endsection

@section('content')
<br />
    <form method="post" action="/boards/create" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="attcnt" id="attcnt" value="0">
        <input type="hidden" name="imgUrl" id="imgUrl" value="">
        <input type="hidden" name="attachFile" id="attachFile" value="">
        <div class="form-group">
            <div class="col-md-12">
                <input type="text" name="subject" id="subject" class="form-control input-lg" placeholder="제목을 입력하세요." />
            </div>
        <br />
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <textarea class="form-control" id="content" name="content" rows="5" placeholder="내용을 입력하세요."></textarea>
            </div>
        </div>
        <br />
        <br />
        <div class="form-group">
            <div class="col-md-12 text-center">
                <button type="button" name="edit" class="btn btn-primary input-lg" onclick="sendsubmit()">등록</button>
            </div>
        </div>
    </form>
<script>
    function sendsubmit(){
        var subject=$("#subject").val();
        var content=$("#content").val();
        var data = {
            subject : subject,
            content : content
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.create') }}',
            dataType: 'json',
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