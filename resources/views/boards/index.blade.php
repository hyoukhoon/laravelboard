@extends('boards.layout')
@section('content')
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
            <th scope="col">등록일</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($boards as $board)
                <tr>
                    <th scope="row">{{ $board->bid }}</th>
                    <td>{{$board->userid}}</td>
                    <td>{{$board->subject}}</td>
                    <td>{{ date("Y-m-d",strtotime($board->regdate)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="position: absolute;transform: translate(50%, 50%);">
        {!! $boards->withQueryString()->links() !!}
    </dvi>
@endsection