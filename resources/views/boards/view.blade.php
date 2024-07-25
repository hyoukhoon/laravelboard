@extends('boards.layout')

@section('header')
    @include('boards.toptitle', ['toptitle'=>'게시판 보기', 'multi'=>$boards->multi])
@endsection

@section('content')

    <table class="table table-striped table-hover">
        <tbody>
            <tr>
                <th width="200">제목</th>
                <td>{{ $boards->subject }}</td>
            </tr>
            <tr>
                <td colspan="2">글쓴이 : {{ $boards->userid }} / 조회수 : {{ number_format($boards->cnt) }} / 등록일 : {{ $boards->regdate }}</td>
            </tr>
            <tr>
                <th width="200">내용</th>
                <td>{!! nl2br($boards->content) !!}</td>
            </tr>
            @if(count($attaches)>0)
            <tr>
                <th width="200">첨부 이미지</th>
                <td>
                    <div class="row row-cols-1 row-cols-md-6 g-4" id="attachFiles" style="margin-left:0px;">
                    @foreach ($attaches as $att)
                    <div id='af_{{ $att->id }}' class='card h-100' style='width:120px;margin-right: 10px;margin-bottom: 10px;'><a href="#" onclick="window.open('/boards/imgpop/{{ $att->filename }}','imgpop','width=600,height=400,scrollbars=yes');"><img src='/images/{{ $att->filename }}' width='100' /></a></div>
                    @endforeach
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <div align="right">
        <a href="/boards/{{ $boards->multi }}/?page={{ $boards->pagenumber }}" class="btn btn-primary">목록</a>
    </div>
    @endsection    