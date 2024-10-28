@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
                                        ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>{{ Str::limit($news->title , 60) }}</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> News</a></li>
                        <li class="active">Single News</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Blog
                                        ============================================= -->
    <div class="blog-area single full-blog right-sidebar full-blog default-padding">
        <div class="container">
            <div class="row">
                <div class="blog-items">
                    <div class="blog-content col-md-8">

                        <div class="single-item">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3><b>{{ $news->title }}</b></h3>
                                    </center>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="text-right" style="color:#ffb606"> <i class="fas fa-calendar-alt "></i>
                                        {{ $news->updated_at }}</h4>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="item">
                                <!-- Start Post Thumb -->
                                <div class="thumb">
                                    <a href="#">
                                        @php
                                            // Decode the image field (stored as JSON) to get an array of image paths
                                            $get_the_file_name_in_array = json_decode($news->images, true);

                                            // If it's not JSON encoded, split the comma-separated string
if ($get_the_file_name_in_array === null) {
    $get_the_file_name_in_array = explode(',', $news->images);
                                            }
                                        @endphp

                                        @foreach ($get_the_file_name_in_array as $value)
                                            @php
                                                // Clean up the file name by removing unwanted characters
                                                $file_name = str_replace(['[', ']', '"'], '', trim($value));
                                                // Construct the file path
                                                $path = 'backend/assets/images/news/' . $file_name;

                                            @endphp

                                            <!-- Ensure the file exists before displaying -->
                                            @if (file_exists(public_path($path)))
                                                <a class="venobox" data-gall="gallery01" href="{{ $path }}">
                                                    <img src="{{ asset($path) }}" style=" padding: 5px;" alt="News Image">
                                                </a>
                                            @endif
                                        @endforeach
                                    </a>
                                </div>

                            </div>
                            <!-- Start Post Thumb -->

                            <div class="info">
                                <div class="content">

                                    {!! $news->description !!}

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Start Sidebar -->
                <div class="sidebar col-md-4">
                    <aside>


                        <div class="sidebar-item recent-post">
                            <div class="title">
                                <h4>Recent News</h4>
                            </div>
                            <div style="max-height: 450px; overflow-y: auto">
                                <ul>
                                    @foreach ($all_news as $news)
                                        <li>
                                            <div class="info">
                                                <a
                                                    href="{{ url('single-news') }}/{{ $news->slug }}">{{ $news->title }}</a>
                                                <div class="meta-title"><span class="post-date "
                                                        style="color:#ffb606"><b>{{ $news->updated_at }}</b></span>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ url('all-news') }}" class="btn btn-theme effect btn-md"> View All</a>
                                    </div>

                                </ul>
                            </div>
                            <br>



                        </div>


                        <div class="sidebar-item category">
                            <div class="title">
                                <h4>Useful Links</h4>
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
    <!-- End Blog -->
@endsection
