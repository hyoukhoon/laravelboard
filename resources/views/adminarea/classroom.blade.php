@extends('adminarea.layout')
@section('content')
    <div class="pagetitle">
      <h1>Data Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Data</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Datatables</h5>
              <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      분류
                    </th>
                    <th>제목</th>
                    <th>조회</th>
                    <th>댓글</th>
                    <th data-type="date" data-format="YYYY/DD/MM">등록일</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($cls as $cs)
                  <tr>
                    <td>{{ $cs->cate }}</td>
                    <td>{{ $cs->subject }}</td>
                    <td>{{ $cs->cnt }}</td>
                    <td>{{ $cs->memo_cnt }}</td>
                    <td>{{ $cs->created_at }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection