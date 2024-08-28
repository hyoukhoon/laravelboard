<div class="col-lg-3 sidebar">

    <div class="widgets-container">

      <!-- Blog Author Widget 2 -->
      {{-- <div class="blog-author-widget-2 widget-item">

        <div class="d-flex flex-column align-items-center">
          <img src="/assets/img/blog/blog-author.jpg" class="rounded-circle flex-shrink-0" alt="">
          <h4>Jane Smith</h4>
          <div class="social-links">
            <a href="https://x.com/#"><i class="bi bi-twitter-x"></i></a>
            <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com/#"><i class="biu bi-instagram"></i></a>
            <a href="https://instagram.com/#"><i class="biu bi-linkedin"></i></a>
          </div>

          <p>
            Itaque quidem optio quia voluptatibus dolorem dolor. Modi eum sed possimus accusantium. Quas repellat voluptatem officia numquam sint aspernatur voluptas. Esse et accusantium ut unde voluptas.
          </p>

        </div>
      </div><!--/Blog Author Widget 2 --> --}}

      <!-- Search Widget -->
      <div class="search-widget widget-item">

        <h3 class="widget-title">Search</h3>
        <form action="">
          <input type="text">
          <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
        @foreach ($cates as $c)
          <li>{{ $c->name }}</li>
        @endforeach
      </div><!--/Search Widget -->

      <!-- Recent Posts Widget -->
      <div class="recent-posts-widget widget-item">

        <h3 class="widget-title">Recent Posts</h3>

        <div class="post-item">
          <img src="/assets/img/blog/blog-recent-1.jpg" alt="" class="flex-shrink-0">
          <div>
            <h4><a href="blog-details.html">Nihil blanditiis at in nihil autem</a></h4>
            <time datetime="2020-01-01">Jan 1, 2020</time>
          </div>
        </div><!-- End recent post item-->

        <div class="post-item">
          <img src="/assets/img/blog/blog-recent-2.jpg" alt="" class="flex-shrink-0">
          <div>
            <h4><a href="blog-details.html">Quidem autem et impedit</a></h4>
            <time datetime="2020-01-01">Jan 1, 2020</time>
          </div>
        </div><!-- End recent post item-->

        <div class="post-item">
          <img src="/assets/img/blog/blog-recent-3.jpg" alt="" class="flex-shrink-0">
          <div>
            <h4><a href="blog-details.html">Id quia et et ut maxime similique occaecati ut</a></h4>
            <time datetime="2020-01-01">Jan 1, 2020</time>
          </div>
        </div><!-- End recent post item-->

        <div class="post-item">
          <img src="/assets/img/blog/blog-recent-4.jpg" alt="" class="flex-shrink-0">
          <div>
            <h4><a href="blog-details.html">Laborum corporis quo dara net para</a></h4>
            <time datetime="2020-01-01">Jan 1, 2020</time>
          </div>
        </div><!-- End recent post item-->

        <div class="post-item">
          <img src="/assets/img/blog/blog-recent-5.jpg" alt="" class="flex-shrink-0">
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