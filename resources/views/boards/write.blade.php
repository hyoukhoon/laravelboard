@extends('boards.layout')

@section('header')
    @include('boards.toptitle', ['toptitle'=>'게시판 쓰기'])
@endsection

@section('content')
<br />
    <form method="post" action="/boards/create" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="attcnt" id="attcnt" value="0">
        <input type="hidden" name="imgUrl" id="imgUrl" value="">
        <input type="hidden" name="attachFile" id="attachFile" value="">
        <div class="form-group">
            <div class="col-md-12">
                <input type="text" name="subject" id="subject" class="form-control input-lg" placeholder="제목을 입력하세요." />
            </div>
        <br />
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <textarea class="form-control" id="content" name="content" rows="5" placeholder="내용을 입력하세요."></textarea>
            </div>
        </div>
        <br />
        <div class="form-group">
            <div class="col-md-12">
                <input type="file" name="afile" id="afile" accept="image/*" multiple class="form-control" aria-label="Large file input example">
            </div>
        </div>
        <br />
        <br />
        <div class="form-group">
            <div class="col-md-12 text-center">
                <button type="button" name="edit" class="btn btn-primary input-lg" onclick="sendsubmit()">등록</button>
            </div>
        </div>
    </form>
<script>
    function sendsubmit(){
        var subject=$("#subject").val();
        var content=$("#content").val();
        var formData = new FormData();
        var files = $('#afile').prop('files');
        // for(var i=0; i < files.length; i++) {
        //     console.log(files[i]);
        // }
        // return false;
        formData.append("afile", files[0]);
        formData.append("subject", subject);
        formData.append("content", content);
        formData.append("multi", '{{ $multi }}');
        // var data = {
        //     subject : subject,
        //     content : content
        // };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('boards.create') }}',
            dataType: 'json',
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                location.href='/boards/show/'+data.bid+'/1';
            },
            error: function(data) {
                console.log("error" +data);
            }
        });
    }
</script>    
@endsection