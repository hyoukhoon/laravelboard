@extends('blog.layout')
@section('content')

<!-- Page Title -->
    {{-- <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
          <h1 class="mb-2 mb-lg-0">Single Post</h1>
          <nav class="breadcrumbs">
            <ol>
              <li><a href="index.html">Home</a></li>
              <li class="current">Single Post</li>
            </ol>
          </nav>
        </div>
      </div><!-- End Page Title --> --}}

      <!-- Section Title -->
    <div class="container section-title" style="margin-bottom:0px;margin-top:10px;" data-aos="fade-up">
        <div class="section-title-container d-flex align-items-center justify-content-between" style="padding-bottom:0px;">
            <h2>강의실</h2>
            <p>개발자가 직접 알려주는 PHP 강의실입니다.</p>
        </div>
    </div>
    <!-- End Section Title -->
  
      <div class="container">
        <div class="row">
  
          <div class="col-lg-9">
  
            <!-- Blog Details Section -->
            <section id="blog-details" class="blog-details section">
              <div class="container">
  
                <article class="article">
  
                    <h2 class="title" style="margin:0px;">{{ $cls->subject }}</h2>
  
                  <div class="meta-top">
                    <ul>
                      <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-details.html">{{ $cls->userid }}</a></li>
                      <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-details.html"><time>{{ $cls->created_at }}</time></a></li>
                      <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-details.html">{{ $cls->cnt }} Comments</a></li>
                    </ul>
                  </div><!-- End meta top -->
  
                  <div class="content">
                    
                    {!! nl2br($cls->contents) !!}
  
                  </div><!-- End post content -->
  
                  <div class="meta-bottom">
                    <i class="bi bi-folder"></i>
                    <ul class="cats">
                      <li><a href="#">Business</a></li>
                    </ul>
  
                    <i class="bi bi-tags"></i>
                    <ul class="tags">
                      <li><a href="#">Creative</a></li>
                      <li><a href="#">Tips</a></li>
                      <li><a href="#">Marketing</a></li>
                    </ul>
                  </div><!-- End meta bottom -->
  
                </article>
  
              </div>
            </section><!-- /Blog Details Section -->

            @auth()
            @if(auth()->user()->memberlevels>=10)
            <section>
              <div class="text-center">
                <a href="/classmodify/{{ $cls->id }}"><button type="button" class="btn btn-warning">수정</button></a>&nbsp;
                <a href="/classdelete/{{ $cls->id }}" onclick="return confirm('삭제하시겠습니까?');"><button type="button" class="btn btn-danger">삭제</button></a>
              </div>
            </section>
            @endif
            @endauth
  
            <!-- 댓글 리스트 부분 -->
            <section id="blog-comments" class="blog-comments section">
  
              <div class="container">
  
                
  
              </div>
  
            </section><!-- /댓글 리스트 부분 -->
  
            <!-- Comment Form Section -->
            <section id="comment-form" class="comment-form section">
              <div class="container">
  
                <div class="input-group" id="firstmemo" style="margin-top:10px;margin-bottom:10px;">
                  <span class="input-group-text" id="memo_image_view" style="display:none;"></span>
                  <button type="button" id="attmemoimg" class="btn btn-secondary">이미지첨부</button>
                      <input type="hidden" name="memopid" id="memopid" value="{{ time() }}">
                      <input type="hidden" name="modimemoid" id="modimemoid" value="0">
                      <input type="hidden" name="memo_file" id="memo_file">
                  <input type="file" name="upfile" id="upfile" accept="image/*" style="display:none;">
                  <textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memo" id="memo" placeholder="댓글을 입력해주세요"></textarea>
                      @auth()
                      <button type="button" class="btn btn-secondary" style="float:right;" id="memo_submit" onclick="memoup()">입력</button>
                      @else
                          <button type="button" class="btn btn-secondary" style="float:right;" id="memo_submit" onclick="alert('로그인 하셔야 입력할 수 있습니다.');">입력</button>
                      @endauth
                </div>
  
              </div>
            </section><!-- /Comment Form Section -->
  
          </div>
  
          @include('blog.classroomside')
  
        </div>
      </div>

      <script>
        function memoup(){
            var memo=$("#memo").val();
            var memo_file=$("#memo_file").val();
            var data = {
                memo : memo,
                memo_file : memo_file,
                bid : {{ $cls->id }}
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('classroom.memoup') }}',
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

    function memoatt(m){
        $("#modimemoid").val(m);
        $('#upfile').click();
    }

    $("#attmemoimg, .reply_attach").click(function () {
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
        formData.append("modimemoid", modimemoid);
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
                if(modimemoid>0){
                    $("#modi_att_view_"+modimemoid).html(html);
                    $("#modi_att_view_"+modimemoid).show();
                    $("#modimemoimg_"+modimemoid).hide();
                }else{
                    $("#memo_image_view").html(html);
                    $("#memo_image_view").show();
                    $("#attmemoimg").hide();
                    $("#memo_file").val(return_data.fn);
                }
            }
            , beforeSend: function () {
                if(modimemoid>0){
                    $("#modimemoimg_"+modimemoid).hide();
                    $("#modi_att_view_"+modimemoid).show();
                    $('#modi_att_view_'+modimemoid).html('<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>');
                }else{
                    $("#attmemoimg").hide();
                    $("#memo_image_view").show();
                    $('#memo_image_view').html('<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>');
                }
            }
            , complete: function () {
            }
            });
    }

    function memo_modify(m, r){
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
                    if(data.attfile == true){
                        var html='<div class="input-group" id="modifymemo" style="margin-top:10px;margin-bottom:10px;"><div id="af_'+data.att.id+'" class="card h-100" style="text-align:center;"><img src="/images/'+data.att.filename+'" width="80" /><a href="javascript:;" onclick=\'memodeletefile("'+data.att.filename+'","'+data.att.id+'","'+data.att.pid+'")\'><span class="badge text-bg-warning">삭제</span></a></div><input type="hidden" name="memopid" id="memopid" value="'+m+'"><input type="hidden" name="memo_modi_file" id="memo_modi_file"><textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memomodify_'+m+'" id="memomodify_'+m+'">'+data.memos.memo+'</textarea><button type="button" class="btn btn-secondary" style="float:right;" id="memo_modifyup" onclick="memomodifyup('+m+')">수정</button></div>';
                    }else{
                        if(r=="r"){
                            var html='<div class="input-group" id="modifymemo" style="margin-top:10px;margin-bottom:10px;"><input type="hidden" name="memopid" id="memopid" value="'+m+'"><textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memomodify_'+m+'" id="memomodify_'+m+'">'+data.memos.memo+'</textarea><button type="button" class="btn btn-secondary" style="float:right;" id="memo_modifyup" onclick="memomodifyup('+m+')">수정</button></div>';
                        }else{
                            var html='<div class="input-group" id="modifymemo" style="margin-top:10px;margin-bottom:10px;"><span class="input-group-text" id="modi_att_view_'+m+'" style="display:none;"></span><button type="button" id="modimemoimg_'+m+'" class="btn btn-secondary" onclick="memoatt('+m+')">이미지첨부</button><input type="hidden" name="memopid" id="memopid" value="'+m+'"><input type="hidden" name="memo_modi_file" id="memo_modi_file"><textarea class="form-control" aria-label="With textarea" style="height:100px;" name="memomodify_'+m+'" id="memomodify_'+m+'">'+data.memos.memo+'</textarea><button type="button" class="btn btn-secondary" style="float:right;" id="memo_modifyup" onclick="memomodifyup('+m+')">수정</button></div>';
                        }
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

    function memodeletefile(fn,fid,pid){
        if(!confirm('삭제하시겠습니까?')){
            return false;
        }

        var data = {
            fn : fn,
            fid : fid,
            pid : pid
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.memodeletefile') }}',
            dataType: 'json',
            data: data,
            success: function(data) {
                alert("삭제했습니다.");
                memo_modify(pid);
            },
            error: function(data) {
                console.log("error" +JSON.stringify(data));
            }
        });
    }

    function memo_delete(m, b){
        if(!confirm('삭제하시겠습니까?')){
            return false;
        }
        var data = {
            id : m,
            bid : b
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.memodelete') }}',
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

    function reply_write(m, b){
        $("#memo_reply_area_"+m).toggle();
    }

    function memo_reply_up(m, b){
        var memo=$("#memo_reply_"+m).val();
        var data = {
            memo : memo,
            pid : m,
            bid : b
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.memoup') }}',
            dataType: 'json',
            data: data,
            success: function(data) {
            console.log(JSON.stringify(data));
            location.reload();
            },
            error: function(data) {
            console.log("error" +JSON.stringify(data));
            }
        });
    }
</script>

@endsection  