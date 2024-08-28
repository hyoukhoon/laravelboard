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
  
            <!-- Blog Comments Section -->
            <section id="blog-comments" class="blog-comments section">
  
              <div class="container">
  
                
  
              </div>
  
            </section><!-- /Blog Comments Section -->
  
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
@endsection  