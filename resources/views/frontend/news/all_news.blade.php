@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb          ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>All News</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Explore</a></li>
                        <li class="active">News</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    <div class="blog-area single full-blog right-sidebar full-blog default-padding">
        <div class="container">
            <div class="row">
                <div class="blog-items">
                    <div class="blog-content col-md-8">

                        <div class="content-items">

                            @foreach ($all_news as $news)
                                <!-- Single Item -->
                                <div class="single-item">
                                    <div class="item">

                                        <div class="info">
                                            <div class="meta">
                                                <ul>
                                                    <li><i class="fas fa-calendar-alt"></i> {{ $news->updated_at }}</li>
                                                </ul>
                                            </div>

                                            <div class="content">

                                                <h4>
                                                    <a href="#">{{ $news->title }}.</a>
                                                </h4>
                                                <p>
                                                    {{ \Illuminate\Support\Str::words($news->description, 38, '...') }}
                                                </p>
                                                <a href="{{ url('single-news') }}/{{ $news->slug }}"><i
                                                        class="fas fa-plus"></i>
                                                    Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->
                            @endforeach


                        </div>
                        <!-- End Blog Items -->

                        <!-- Pagination -->
                        @if (count($all_news) > 0)
                            <div class="row">
                                <div class="col-md-12 pagi-area">
                                    <nav aria-label="navigation">
                                        <ul class="pagination">
                                            <!-- Previous Page Link -->
                                            @if ($all_news->onFirstPage())
                                                <li class="disabled"><a><i class="fas fa-angle-double-left"></i></a></li>
                                            @else
                                                <li><a href="{{ $all_news->previousPageUrl() }}" rel="prev"><i
                                                            class="fas fa-angle-double-left"></i></a></li>
                                            @endif

                                            <!-- Pagination Elements -->
                                            @foreach ($all_news->getUrlRange(1, $all_news->lastPage()) as $page => $url)
                                                @if ($page == $all_news->currentPage())
                                                    <li class="active"><a>{{ $page }}</a></li>
                                                @else
                                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            @if ($all_news->hasMorePages())
                                                <li><a href="{{ $all_news->nextPageUrl() }}" rel="next"><i
                                                            class="fas fa-angle-double-right"></i></a></li>
                                            @else
                                                <li class="disabled"><a><i class="fas fa-angle-double-right"></i></a></li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Start Sidebar -->
                    <div class="sidebar col-md-4">
                        <aside>
                            <div class="sidebar-item search">
                                <div class="title">
                                    <h4>Search</h4>
                                </div>
                                <div class="sidebar-info">
                                    <form>
                                        <input type="text" class="form-control">
                                        <input type="submit" value="search">
                                    </form>
                                </div>
                            </div>
                            <div class="sidebar-item category">
                                <div class="title">
                                    <h4>Useful Link</h4>
                                </div>
                                <div class="sidebar-info">
                                    <ul>
                                        <li>
                                            <a href="#">Notice <span>69</span></a>
                                        </li>
                                        <li>
                                            <a href="#">Event <span>25</span></a>
                                        </li>
                                        <li>
                                            <a href="#">News <span>18</span></a>
                                        </li>
                                        <li>
                                            <a href="#">Gallery <span>37</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            

                        </aside>
                    </div>
                    <!-- End Start Sidebar -->
                </div>
            </div>
        </div>
    </div>
@endsection
