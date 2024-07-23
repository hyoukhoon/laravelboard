@extends('boards.layout')

@section('header')
    @include('boards.toptitle', ['toptitle'=>'게시판 보기', 'multi'=>$boards->multi])
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
                <td>{!! nl2br($boards->content) !!}</td>
            </tr>
            @if($boards->attachfiles)
            <tr>
                <th width="100">첨부 이미지</th>
                <td>
                    <img src="/images/{{ $boards->attachfiles }}" style="max-width:100%;"><br>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <div align="right">
        <a href="/boards/{{ $boards->multi }}/?page={{ $boards->pagenumber }}" class="btn btn-primary">목록</a>
    </div>
    @endsection    