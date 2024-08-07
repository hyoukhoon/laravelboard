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
        @foreach ($memos as $m)
        <div class="card mt-2">
            <div class="card-header p-2">
                <table>
                    <tbody>
                        <tr class="align-middle">
                            <td rowspan="2" class="pr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                    <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                            </td>
                            <td class="ml">{{ $m->userid }}</td>
                        </tr>
                        <tr>
                            <td>
                                {{ disptime($m->created_at) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body" id="{{ 'memolist_'.$m->id }}">
                <p class="card-text">
                    @if($m->filename)
                        <img src='/images/{{ $m->filename }}' width='100' />
                    @endif
                    {!! nl2br($m->memo) !!}
                </p>
                @auth()
                    @if($m->userid==auth()->user()->userid)
                        <span class="badge bg-secondary" style="cursor:pointer;padding:10px;"><a onclick="memo_modify('{{ $m->id }}')">수정</a></span>
                        <span class="badge bg-secondary" style="cursor:pointer;padding:10px;"><a onclick="memo_delete('{{ $m->id }}','{{ $boards->num }}')">삭제</a></span>
                    @endif
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    <!-- 댓글 리스트 끝 -->

    <!-- 댓글 입력 -->
    <div class="input-group" id="firstmemo" style="margin-top:10px;margin-bottom:10px;">
		<span class="input-group-text" id="memo_image_view" style="display:none;"></span>
		<button type="button" id="attmemoimg" class="btn btn-secondary">이미지첨부</button>
        <input type="hidden" name="memopid" id="memopid" value="{{ time() }}">
        <input type="hidden" name="memo_file" id="memo_file">
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
            var memo_file=$("#memo_file").val();
            var data = {
                memo : memo,
                memo_file : memo_file,
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

    $("#attmemoimg, #modimemoimg").click(function () {
		$('#upfile').click();
    });
    
    $("#upfile").change(function(){
        var formData = new FormData();
        var files = $('#upfile').prop('files');
        for(var i=0; i < files.length; i++) {
            attachFile(files[i]);
        }
    });

    function attachFile(file) {
        var memopid = $("#memopid").val();
        var modimemoid = $("#modimemoid").val();
        var formData = new FormData();
        formData.append("file", file);
        formData.append("pid", memopid);
        formData.append("code", "memoattach");
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '{{ route('boards.saveimage') }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType : 'json' ,
            type: 'POST',
            success: function (return_data) {
                var html = "<img src='/images/"+return_data.fn+"' style='max-width:100%;height:88px;'>";
                $("#memo_image_view").html(html);
                $("#memo_image_view").show();
                $("#attmemoimg").hide();
                $("#memo_file").val(return_data.fn);
            }
            , beforeSend: function () {
                $("#attmemoimg").hide();
                $("#memo_image_view").show();
                $('#memo_image_view').html('<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>');
            }
            , complete: function () {
            }
            });
    }

    function memo_modify(m){
            var data = {
                memoid : m
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('boards.memomodi') }}',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if(data.att[0].filename){
                        var html='<div class="input-group" id="firstmemo" style="margin-top:10px;margin-bottom:10px;"><span class="input-group-text" id="memo_image_view"><img src="/images/'+data.att[0].filename+'" style="max-width:100%;height:88px;""></span><input type="hidden" name="memopid" id="memopid" value="'+m+'"><input type="hidden" name="modimemoid" id="modimemoid" value="'+m+'"><input type="hidden" name="memo_modi_file" id="memo_modi_file"><textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memomodify_'+m+'" id="memomodify_'+m+'">'+data.memos.memo+'</textarea><button type="button" class="btn btn-secondary" style="float:right;" id="memo_modifyup" onclick="memomodifyup('+m+')">수정</button></div>';
                    }else{
                        var html='<div class="input-group" id="firstmemo" style="margin-top:10px;margin-bottom:10px;"><span class="input-group-text" id="memo_image_view" style="display:none;"></span><button type="button" id="modimemoimg" class="btn btn-secondary">이미지첨부</button><input type="hidden" name="memopid" id="memopid" value="'+m+'"><input type="hidden" name="modimemoid" id="modimemoid" value="'+m+'"><input type="hidden" name="memo_modi_file" id="memo_modi_file"><textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memomodify_'+m+'" id="memomodify_'+m+'">'+data.memos.memo+'</textarea><button type="button" class="btn btn-secondary" style="float:right;" id="memo_modifyup" onclick="memomodifyup('+m+')">수정</button></div>';
                    }
                    $("#memolist_"+m).html(html);
                },
                error: function(data) {
                    console.log("error" +JSON.stringify(data));
                }
            });
    }

    function memomodifyup(m){
            var memo=$("#memomodify_"+m).val();
            var data = {
                memo : memo,
                memoid : m
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('boards.memomodifyup') }}',
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