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
        @auth()
            @if($boards->userid==auth()->user()->userid)
                <a href="/boards/write/{{ $boards->multi }}/{{ $boards->bid }}"><button type="button" class="btn btn-secondary">수정</button></a>
                <a href="/boards/delete/{{ $boards->bid }}/{{ $boards->pagenumber }}" class="btn btn-secondary" onclick="return confirm('삭제하시겠습니까?');">삭제</a>
            @endif
        @endauth
        <a href="/boards/{{ $boards->multi }}/?page={{ $boards->pagenumber }}" class="btn btn-primary">목록</a>
    </div>
    <div style="padding:20px;">
    </div>
    <!-- 댓글 입력 -->
    <div class="input-group" id="firstmemo" style="margin-top:10px;margin-bottom:10px;">
		<span class="input-group-text" id="memo_image_view" style="display:none;"></span>
		<button type="button" id="attmemoimg" class="btn btn-secondary">이미지첨부</button>
		<input type="file" name="upfile" id="upfile" accept="image/*" style="display:none;">
		<textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memo" id="memo" placeholder="댓글을 입력해주세요"></textarea>
        @auth()
		    <button type="button" class="btn btn-secondary" style="float:right;" id="memo_submit" onclick="memoup()">입력</button>
        @else
            <button type="button" class="btn btn-secondary" style="float:right;" id="memo_submit" onclick="alert('로그인 하셔야 입력할 수 있습니다.');">입력</button>
        @endauth
    </div>
    <!-- 댓글 입력 끝-->
    
    @endsection    