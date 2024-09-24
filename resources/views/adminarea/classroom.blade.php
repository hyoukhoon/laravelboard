@extends('adminarea.layout')
@section('content')
    <div class="pagetitle">
      <h1>강의실</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">

      <table>
        <tr>
          <td>
            <select class="form-select" name="cate" id="cate" aria-label="Default select example">
              <option value="">전체</option>
              @foreach ($cates as $c)
              <option value="{{ $c->code }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              분류등록
            </button>
          </td>
        </tr>
      </table>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">분류 등록 하기</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input name="catename" id="catename" type="text" class="form-control" placeholder="분류명을 입력하세요" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="cateup">등록</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Bordered Table -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">번호</th>
            <th>분류</th>
            <th>제목</th>
            <th>조회</th>
            <th>댓글</th>
            <th>등록일</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $pagenumber = $_GET["page"]??1;
              $total = $cls->total();
              $idx = $total-(($cls->currentPage()-1) * 20);
          ?>
          @foreach ($cls as $cs)
            <tr>
              <td>{{ $idx-- }}</td>
              <td>{{ cateis($cs->cate) }}</td>
              <td>{{ $cs->subject }}</td>
              <td>{{ $cs->cnt }}</td>
              <td>{{ $cs->memo_cnt }}</td>
              <td>{{ $cs->created_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- End Bordered Table -->
      <div>
        {!! $boards->withQueryString()->links() !!}
    </dvi>
    </section>
<script>
  $("#cateup").click(function () {
		    var catename=$("#catename").val();

        if(!catename){
          alert('분류명을 입력해주세요.');
          return false;
        }

        var data = {
          catename : catename
        };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'post',
            url: '{{ route('adminarea.cateup') }}',
            dataType: 'json',
            data: data,
            success: function(data) {
                if(data.result==true){
                    alert(data.msg);
                    location.reload();
                }else{
                    alert(data.msg);
                    return false;
                }
            },
            error: function(data) {
            console.log("error" +JSON.stringify(data));
            }
        });
    });
</script>
@endsection