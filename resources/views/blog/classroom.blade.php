@extends('blog.layout')
@section('content')
    <!-- Page Title -->
    {{-- <div class="page-title position-relative">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Category</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Categories</li>
          </ol>
        </nav>
      </div>
    </div> --}}
    <!-- End Page Title -->

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


                @foreach ($contents as $cs)
                <div class="col-lg-6">
                  <article class="position-relative h-100">

                    <div class="post-img position-relative overflow-hidden">
                      <a href="/classview/{{ $cs->id }}/1" class="readmore stretched-link">
                      <img src="/images/{{ $cs->thumbnail }}" class="img-fluid" alt=""></a>
                      <span class="post-date">{{ disptime($cs->created_at) }}</span>
                    </div>

                    <div class="post-content d-flex flex-column">
                      <a href="/classview/{{ $cs->id }}/1" class="readmore stretched-link">
                      <h3 class="post-title">{{ $cs->subject }}</h3>
                      </a>
                      <div class="meta d-flex align-items-center">
                        <div class="d-flex align-items-center">
                          <i class="bi bi-person"></i> <span class="ps-2">{{ $cs->username }}</span>
                        </div>
                        <span class="px-3 text-black-50">/</span>
                        <div class="d-flex align-items-center">
                          <i class="bi bi-folder2"></i> <span class="ps-2">PHP기초</span>
                        </div>
                      </div>

                      <p>
                        <a href="/classview/{{ $cs->id }}/1" class="readmore stretched-link">
                        {{ $cs->shorts }}
                        </a>
                      </p>

                      {{-- <hr>

                      <a href="/classview/{{ $cs->id }}/1" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a> --}}

                    </div>

                  </article>
                </div><!-- End post list item -->
                @endforeach

                

              </div>
            </div>

          </section><!-- /Blog Posts Section -->
          @auth()
          @if(auth()->user()->memberlevels>=10)
          <section>
            <div class="text-center">
              <a href="/classwrite"><button type="button" class="btn btn-primary">글작성</button></a>
            </div>
          </section>
          @endif
          @endauth
          <!-- Blog Pagination Section -->
          <section id="blog-pagination" class="blog-pagination section">

            <div class="container">
              <div class="d-flex justify-content-center">
                <ul>
                  <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#" class="active">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li>...</li>
                  <li><a href="#">10</a></li>
                  <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
                </ul>
              </div>
            </div>

          </section><!-- /Blog Pagination Section -->

        </div>

        @include('blog.classroomside')

      </div>
    </div>

@endsection