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
    <div style="padding:10px;">
    </div>

    <!--댓글 리스트 시작 -->
    <div id="reply">
        @foreach ($memos as $key => $m)
            <div class="d-flex" id="{{ 'memolist_'.$m->id }}">
                <div class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"></path>
                </svg>
                </div>
                <div class="flex-fill" style="width:100%">
                    <div class="card mt-2">
                        <div class="card-header">
                            <table>
                                <tbody><tr class="align-middle">
                                    <td rowspan="2" class="pr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                            <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
                                          </svg>
                                    </td>
                                    <td class="ml">{{ $m->name }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <font size="2">{{ disptime($m->regdate) }}</font> 
                                        <span style="cursor:pointer" onclick="#"></span>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $m->memo }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- 댓글 리스트 끝 -->

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
    <div style="padding:20px;">
    </div>
    <script>
        function memoup(){
            var memo=$("#memo").val();
            var data = {
                memo : memo,
                bid : {{ $boards->bid }}
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('boards.memoup') }}',
                dataType: 'json',
                data: data,
                success: function(data) {
                    location.reload();
                },
                error: function(data) {
                console.log("error" +JSON.stringify(data));
                }
            });
        }
    </script>
    @endsection    