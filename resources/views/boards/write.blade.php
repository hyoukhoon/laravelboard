@extends('boards.layout')
@section('content')
<br />
    <form method="post" action="/boards/create" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="attcnt" id="attcnt" value="0">
        <input type="hidden" name="imgUrl" id="imgUrl" value="">
        <input type="hidden" name="attachFile" id="attachFile" value="">
        <div class="form-group">
        <div class="col-md-8">
        <input type="text" name="subject" id="subject" class="form-control input-lg" placeholder="제목을 입력하세요." />
        </div>
        <br />
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <textarea class="form-control" id="contents" name="contents" rows="5"></textarea>
            </div>
        </div>
        <br />
        <br />
        <div class="col-md-8 form-group text-center">
        <button type="button" name="edit" class="btn btn-primary input-lg" onclick="sendsubmit()">등록</button>
        </div>
    </form>
@endsection