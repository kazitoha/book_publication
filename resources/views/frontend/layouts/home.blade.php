@extends('frontend.layouts.app')
@section('content')
    <!-- Start Banner -->
    <div class="banner-area">
        <div id="bootcarousel" class="carousel content-less text-light top-pad text-dark slide animate_text"
            data-ride="carousel">
            <div class="carousel-inner carousel-zoom">
                @foreach ($sliders as $index => $slider)
                    <div class="item bg-cover lazyload @if ($index == 0) active @endif"
                        style="background-image: url(/{{ $slider->image }});">
                        <div class="box-table">
                            <div class="box-cell shadow dark">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="content animate__animated animate__fadeInUp">
                                                {{-- <h4>Welcome to Bureau of Business Research</h4> --}}
                                                <h2><strong>{!! Str::limit($slider->title, 100) !!}</strong></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Banner -->


    <!-- Start marquee ============================================= -->
    <div>
        <div class="breaking-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex">
                            {{-- <div class="news-title">Important Notice:</div> --}}
                            <div class="news-scroll">
                                <marquee behavior="scroll" direction="left" scrollamount="5">
                                    {{-- @foreach ($all_notice as $notice) --}}
                                    <span class="dot"></span>
                                    {{-- <a href="{{ url('single-notice') }}/{{ $notice->slug }}" class="ticker__item">
                                            {{ $notice->title }}
                                        </a> --}}
                                    <a href="#" class="ticker__item">
                                        Welcome to Bureau of Business Research
                                    </a>
                                    {{-- @endforeach --}}
                                </marquee>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Marquee -->

    <!-- Start Testimonials ============================================= -->
    <div class="testimonials-area active-dots default-padding animate__animated animate__fadeInUp"
        id="Vice-Chancellor-part">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="testimonial-items testimonial-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        <div class="border-shadow">
                            <div class="row">
                                <div class="col-lg-5 col-md-6 text-center">
                                    <div class="voice-left-chanecllor">
                                        <div class="voice-images-box">
                                            <img src="{{ asset('frontend/WhatsApp Image 2024-10-27 at 5.30.51 PM.jpeg') }}"
                                                alt="">
                                            {{-- <p>_______________</p>
                                            <h5>Chairman</h5> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-9">
                                    <div class="voice-right-chanecllor">
                                        <h2>About Us</h2>
                                        <p style="text-align: justify;">
                                            {{ Str::limit(
                                                'Established as a specialised business research arm/wing of the Faculty of Business Studies, University of Dhaka; the Bureau of Business Research (BBR) has emerged as a pioneer institution for research in the areas of industry, trade and commerce. The establishment of such a research organisation was greatly felt in the late 1960’s and the idea was finally accepted with the elevating of Commerce Department into a Faculty in 1970. After the independence in 1971, the field of business research got heightened importance. The Faculty members in a meeting on January 1, 1972 agreed to float a “Bureau of Business Research” in the Faculty. A committee consisting of four members including Dr. M. Habibullah, Dr. A.H.M. Habibur Rahman, Dr.M. Afzalur Rahim, and Mr. M. Nasiruddin, was formed in January 1972 to prepare the draft constitution of the proposed Bureau. The constitution was approved by the Faculty members in a meeting held on January 11, 1972. Initially a small Executive Committee was formed to run the affairs of the Bureau with the following members: Dr.A. Farouk, Dr. M. Habibullah and Dr. A.H.M.Habibur Rahman.',
                                                1200,
                                            ) }}
                                            <a href="{{ url('bbr-history') }}">Read More</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->

                        <!-- Single Item -->
                        {{-- <div class="border-shadow">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 text-center">
                                    <div class="voice-left-chanecllor">
                                        <div class="voice-images-box">
                                            <img src="https://fenigaacademy.edu.bd/storage/speech_files/12.png"
                                                alt="">
                                            <p>
                                                _______________
                                            </p>
                                            <h5>Director</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <div class="voice-right-chanecllor">
                                        <h4>Message from the Director</h4>
                                        <p>
                                            {{ Str::limit(
                                                ' Dr. Sayema Haque Bidisha has started her journey as Pro-Vice Chancellor (Administration) on September 02, 2024. She is a professor in the Department of
                                                                                                                                        Economics, University of Dhaka. She did her bachelor’s as well as master’s from the Department of Economics, University of Dhaka. 
                                                                                                                                        She did her MSc. from the University of Bath, UK and PhD in Labour Economics from the University of Nottingham, UK under Commonwealth Scholarship scheme. 
                                                                                                                                        Her research interest lies on labour economics, development economics, and microeconometrics. Her work
                                                                                                                                        involves both empirical analysis as well as policy focused research with
                                                                                                                                        emphasis on developing countries. In the context of Bangladesh, she worked on
                                                                                                                                        various research projects on labour market, demographic dividend and youth
                                                                                                                                        population, skill and education, gender and women empowerment, gender budgeting,
                                                                                                                                        migration and remittance earning, credit and food security, poverty and
                                                                                                                                        vulnerability, SDG financing, financial inclusion etc. In addition, Dr. Bidisha
                                                                                                                                        also contributed in preparing various policy documents and government flagship
                                                                                                                                        objects.',
                                                2000,
                                            ) }}

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->

    <!-- Start Weekly Top
                                                                                                                                                                                                                                                                                                                                                                        ============================================= -->
    <div class="weekly-top-items carousel-shadow default-padding animate__animated animate__fadeInUp">
        <div class="container">
            <div class="row">
                <div class="site-heading text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <h2>Notices</h2>

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-8">
                    <div class="top-courses">
                        <div class="heading">
                            <h4>Notices </h4>
                        </div>
                        <div class="top-course-items top-courses-carousel owl-carousel owl-theme">
                            @foreach ($all_notice as $notice)
                                <!-- Single Item -->
                                <div class="item">
                                    <div class="thumb">
                                        @empty($notice->image)
                                            <img src="/frontend/assets/img/800x600.png" alt="Thumb" style="height: 177px;">
                                        @endempty
                                        @empty(!$notice->image)
                                            <img src="{{ asset($notice->image) }}" alt="Thumb" style="height: 177px;">
                                        @endempty
                                        <div class="overlay">
                                            <ul>
                                                <li><i class="fas fa-clock"></i>{{ $notice->updated_at }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info">

                                        <h4>
                                            <a href="#"> {{ Str::limit($notice->title, 40) }}</a>
                                        </h4>
                                        <p>
                                            {!! Str::limit($notice->description, 80) !!}
                                        </p>
                                        <div class="footer-meta">
                                            <a class="btn btn-theme effect btn-sm"
                                                href="{{ url('single-notice') }}/{{ $notice->slug }}">Read More..</a>

                                        </div>
                                    </div>
                                </div>

                                <!-- Single Item -->
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="top-author">
                        <h4 class="div-title">Notices List</h4>
                        <div class="author-items">

                            @foreach ($all_notice as $notice)
                                <!-- Single Item -->
                                <div class="item">
                                    {{-- <div class="thumb">
                                <a href="#">
                                    <img src="{{asset($notice->image)}}" alt="Thumb">
                                </a>
                            </div> --}}
                                    <div class="info">
                                        <h5><a
                                                href="{{ url('single-notice') }}/{{ $notice->slug }}">{{ $notice->title }}</a>
                                        </h5>

                                    </div>
                                </div>
                                <!-- End Single Item -->
                            @endforeach


                            <a href="all-notice">View All <i class="fas fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Weekly Top -->

    <!-- Start Event
                                                                                                                                                                                                                                                                                                                                                                        ============================================= -->
    <div class="event-area default-padding">
        <div class="container">
            <div class="row">
                <div class="site-heading text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <h2>Events</h2>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="event-items">
                        @foreach ($all_event as $event)
                            <!-- Single Item -->
                            <div class="item">
                                <div class="col-md-5 thumb"
                                    style="
                                    @php
// Decode the JSON-encoded images and get the first image
                                        $images = json_decode($event->image, true);
                                        $firstImage = !empty($images) ? $images[0] : null; @endphp
                                    
                                    @if ($firstImage) background-image: url({{ asset('backend/assets/images/event/' . $firstImage) }});
                                    @else
                                        background-image: url(/frontend/assets/img/800x600.png); @endif
                                    ">
                                </div>
                                <div class="col-md-7 info">
                                    <div class="info-box">
                                        <div class="date">
                                            <strong>{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</strong>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('M, Y') }}
                                        </div>
                                        <div class="content">
                                            <h4>
                                                <a href="#">{{ Str::limit($event->title, 70) }}</a>
                                            </h4>

                                            <p>{!! Str::limit($event->description, 100) !!}</p>
                                            <div class="bottom">
                                                <a href="{{ url('single-event') }}/{{ $event->slug }}"
                                                    class="btn circle btn-dark border btn-sm">
                                                    <i class="fas fa-chart-bar"></i> Read More..
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        @endforeach
                    </div>
                </div>
                <div class="more-btn col-md-12 text-center">
                    <a href="all-event" class="btn btn-theme effect btn-md">View All Events</a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Event -->

    <!-- Start Fun Factor
                                                                                                                                                                                                                                                                                                                                                                        ============================================= -->
    <div class="fun-factor-area default-padding text-center bg-fixed shadow dark-hard"
        style="background-image: url(/frontend/assets/img/2440x1578.png);">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            {{-- <i class="fa-solid fa-book"></i> --}}
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="3534" data-speed="5000"></span>
                            <span class="medium">COMPLETED RESEARCH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="3000" data-speed="2000"></span>
                            <span class="medium">ONGOING RESEARCH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="896" data-speed="5000"></span>
                            <span class="medium">OUR RESEARCH TEAM</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="172" data-speed="5000"></span>
                            <span class="medium">RESEARCH REPORT</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Fun Factor -->


    <!-- Start Blog
                                                                                                                                                                                                                                                                                                                                                                        ============================================= -->
    <div class="blog-area default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="site-heading text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <h2>News</h2>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog-items">
                    @foreach ($all_news as $news)
                        <!-- Single Item -->
                        <div class="col-md-4 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <a href="#">

                                        @php
                                            // Decode the JSON-encoded images and get the first image
                                            $images = json_decode($news->images, true);
                                        $firstImage = !empty($images) ? $images[0] : null; @endphp

                                        @if ($firstImage)
                                            <img src="{{ asset('backend/assets/images/news/' . $firstImage) }}"
                                                alt="Thumb">
                                        @else
                                            <img src="/frontend/assets/img/800x600.png" alt="Thumb">
                                        @endif

                                    </a>
                                </div>
                                <div class="info">
                                    <div class="content">
                                        <div class="tags">
                                            <a href="all-news">News</a>
                                            <a href="" class="text-right">Norice</a>
                                        </div>
                                        <h4>
                                            <a href="#"> {{ Str::limit($news->title, 50) }}</a>
                                        </h4>
                                        <p>
                                            {!! Str::limit($news->description, 110) !!}
                                        </p>
                                        <a href="{{ url('single-news') }}/{{ $news->slug }}"><i
                                                class="fas fa-plus"></i> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Item -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->
@endsection
