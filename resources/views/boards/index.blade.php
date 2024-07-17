@extends('boards.layout')
@section('content')

    @section('header')
    <header class="w-2/3 mx-auto mt-16 text-right">
        @guest()
            <a href="/login" class="text-xl">로그인</a> / 
            <a href="/signup" class="text-xl">회원가입</a>
        @endguest
        @auth()
            <form action="/logout" method="post" class="inline-block">
                @csrf
                <span class="text-xl text-blue-500">{{auth()->user()->nickName}}</span> / 
                <a href="/logout"><button class="text-xl">로그아웃</button></a>
            </form>
        @endauth
    </header>
    @endsection
    <h2 class="mt-4 mb-3">게시판 목록</h2>
    <div style="text-align:right;">
        <button class="text-xl">등록</button></a>
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