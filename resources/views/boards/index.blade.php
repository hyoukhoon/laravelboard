@extends('blog.layout')
@section('header')
    @include('boards.toptitle', ['toptitle'=>'게시판 목록', 'multi'=>$multi])
@endsection
@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
  
            <!-- Blog Posts Section -->
            <section id="blog-posts" class="blog-posts section">
  
              <div class="container">
                <div class="row gy-4">

                    <table class="table table-striped table-hover">
                        <colgroup>
                            <col width="10%"/>
                            <col width="15%"/>
                            <col width="45%"/>
                            <col width="15%"/>
                            <col width="15%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <th scope="col">이름</th>
                            <th scope="col">제목</th>
                            <th scope="col">조회수</th>
                            <th scope="col">등록일</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $pagenumber = $_GET["page"]??1;
                                $total = $boards->total();
                                $idx = $total-(($boards->currentPage()-1) * 20);
                            ?>
                            @foreach ($boards as $board)
                                <tr>
                                    <th scope="row">{{ $idx-- }}</th>
                                    <td>{{ $board->userid }}</td>
                                    <td><a href="/boards/show/{{$board->bid}}/{{$pagenumber}}">{{ $board->subject }}</a> {!! dispattach($board->bid) !!} {!! dispmemo($board->memo_cnt,$board->memo_date) !!} {!! dispnew($board->regdate) !!} </td>
                                    <td>{{ number_format($board->cnt) }}</td>
                                    <td>{{ disptime($board->regdate) }}</td>
                                </tr>
                            @endforeach
                            @if(!$total)
                                <tr>
                                    <th scope="row" colspan="5">게시물이 없습니다.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div>
                        {!! $boards->withQueryString()->links() !!}
                    </dvi>

                    <div style="text-align:right;">
                        <a href="/boards/write/{{ $multi }}"><button class="text-xl">등록</button></a>
                    </div>
                </div>
            </div>

          </section><!-- /Blog Posts Section -->
@endsection