@extends('boards.layout')

@section('header')
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <span class="fs-4">게시판 보기</span>
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
    

    <table class="table table-striped table-hover">
        <tbody>
            <tr>
                <th width="100">제목</th>
                <td>{{ $boards->subject }}</td>
            </tr>
            <tr>
                <td colspan="2">글쓴이 : {{ $boards->userid }} / 조회수 : {{ number_format($boards->cnt) }} / 등록일 : {{ $boards->regdate }}</td>
            </tr>
            <tr>
                <th width="100">내용</th>
                <td>{!! $boards->content !!}</td>
            </tr>
        </tbody>
    </table>
    <div align="right">
        <a href="/boards/?page={{ $boards->pagenumber }}" class="btn btn-primary">목록</a>
    </div>
    @endsection    