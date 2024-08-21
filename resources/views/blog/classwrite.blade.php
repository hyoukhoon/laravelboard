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
  
          <div class="col-lg-8">
  
            <!-- Comment Form Section -->
            <section id="comment-form" class="comment-form section">
              <div class="container">
  
                <form action="">
  
                  <h4>강의실에 강좌 올리기</h4>
                  <p>좋은 글을 남깁니다.</p>
                  <div class="row">
                    <div class="col form-group">
                      <input name="website" type="text" class="form-control" placeholder="Your Website">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                    </div>
                  </div>
  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">등록</button>
                  </div>
  
                </form>
  
              </div>
            </section><!-- /Comment Form Section -->
  
          </div>
  
          <div class="col-lg-4 sidebar">
  
            <div class="widgets-container">
  
              <!-- Blog Author Widget -->
              <div class="blog-author-widget widget-item">
  
                <div class="d-flex flex-column align-items-center">
                  <div class="d-flex align-items-center w-100">
                    <img src="assets/img/blog/blog-author.jpg" class="rounded-circle flex-shrink-0" alt="">
                    <div>
                      <h4>Jane Smith</h4>
                      <div class="social-links">
                        <a href="https://x.com/#"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/#"><i class="biu bi-instagram"></i></a>
                        <a href="https://instagram.com/#"><i class="biu bi-linkedin"></i></a>
                      </div>
                    </div>
                  </div>
  
                  <p>
                    Itaque quidem optio quia voluptatibus dolorem dolor. Modi eum sed possimus accusantium. Quas repellat voluptatem officia numquam sint aspernatur voluptas. Esse et accusantium ut unde voluptas.
                  </p>
  
                </div>
  
              </div><!--/Blog Author Widget -->
  
              <!-- Search Widget -->
              <div class="search-widget widget-item">
  
                <h3 class="widget-title">Search</h3>
                <form action="">
                  <input type="text">
                  <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
  
              </div><!--/Search Widget -->
  
              <!-- Recent Posts Widget -->
              <div class="recent-posts-widget widget-item">
  
                <h3 class="widget-title">Recent Posts</h3>
  
                <div class="post-item">
                  <img src="assets/img/blog/blog-recent-1.jpg" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="blog-details.html">Nihil blanditiis at in nihil autem</a></h4>
                    <time datetime="2020-01-01">Jan 1, 2020</time>
                  </div>
                </div><!-- End recent post item-->
  
                <div class="post-item">
                  <img src="assets/img/blog/blog-recent-2.jpg" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="blog-details.html">Quidem autem et impedit</a></h4>
                    <time datetime="2020-01-01">Jan 1, 2020</time>
                  </div>
                </div><!-- End recent post item-->
  
                <div class="post-item">
                  <img src="assets/img/blog/blog-recent-3.jpg" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="blog-details.html">Id quia et et ut maxime similique occaecati ut</a></h4>
                    <time datetime="2020-01-01">Jan 1, 2020</time>
                  </div>
                </div><!-- End recent post item-->
  
                <div class="post-item">
                  <img src="assets/img/blog/blog-recent-4.jpg" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="blog-details.html">Laborum corporis quo dara net para</a></h4>
                    <time datetime="2020-01-01">Jan 1, 2020</time>
                  </div>
                </div><!-- End recent post item-->
  
                <div class="post-item">
                  <img src="assets/img/blog/blog-recent-5.jpg" alt="" class="flex-shrink-0">
                  <div>
                    <h4><a href="blog-details.html">Et dolores corrupti quae illo quod dolor</a></h4>
                    <time datetime="2020-01-01">Jan 1, 2020</time>
                  </div>
                </div><!-- End recent post item-->
  
              </div><!--/Recent Posts Widget -->
  
              <!-- Tags Widget -->
              <div class="tags-widget widget-item">
  
                <h3 class="widget-title">Tags</h3>
                <ul>
                  <li><a href="#">App</a></li>
                  <li><a href="#">IT</a></li>
                  <li><a href="#">Business</a></li>
                  <li><a href="#">Mac</a></li>
                  <li><a href="#">Design</a></li>
                  <li><a href="#">Office</a></li>
                  <li><a href="#">Creative</a></li>
                  <li><a href="#">Studio</a></li>
                  <li><a href="#">Smart</a></li>
                  <li><a href="#">Tips</a></li>
                  <li><a href="#">Marketing</a></li>
                </ul>
  
              </div><!--/Tags Widget -->
  
            </div>
  
          </div>
  
        </div>
      </div>
@endsection  