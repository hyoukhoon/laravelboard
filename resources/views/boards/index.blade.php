@extends('boards.layout')

@section('header')
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <span class="fs-4">게시판 목록</span>
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
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors as $key => $error)
            <li>{{ $key }}</li>
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div style="text-align:right;">
        <a href="/boards/write"><button class="text-xl">등록</button></a>
    </div>
    <table class="table table-striped table-hover">
        <colgroup>
            <col width="10%"/>
            <col width="15%"/>
            <col width="45%"/>
            <col width="15%"/>
            <col width="15%"/>
        </colgroup>
        <thead>
        <tr>
            <th scope="col">번호</th>
            <th scope="col">이름</th>
            <th scope="col">제목</th>
            <th scope="col">조회수</th>
            <th scope="col">등록일</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $pagenumber = $_GET["page"]??1;
                $idx = $boards->total()-(($boards->currentPage()-1) * 20);
            ?>
            @foreach ($boards as $board)
                <tr>
                    <th scope="row">{{ $idx-- }}</th>
                    <td>{{ $board->userid }}</td>
                    <td><a href="/boards/show/{{$board->bid}}/{{$pagenumber}}">{{ $board->subject }}</a></td>
                    <td>{{ number_format($board->cnt) }}</td>
                    <td>{{ date("Y-m-d",strtotime($board->regdate)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {!! $boards->withQueryString()->links() !!}
    </dvi>
@endsection