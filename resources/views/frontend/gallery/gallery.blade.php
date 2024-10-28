@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
                                        ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/assets/img/2440x1578.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>Our Gallery</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#">Page</a></li>
                        <li class="active">Gallery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Portfolio
                                        ============================================= -->
    <div id="portfolio" class="portfolio-area default-padding">
        <div class="container">
            <div class="portfolio-items-area text-center">
                <div class="row">
                    <div class="col-md-12 portfolio-content">
                        {{-- <div class="mix-item-menu active-theme">
                            <button class="active" data-filter="*">All</button>
                            <button data-filter=".campus">Campus</button>
                            <button data-filter=".teachers">Teachers</button>
                            <button data-filter=".education">Education</button>
                            <button data-filter=".ceremony">Ceremony</button>
                            <button data-filter=".students">Students</button>
                        </div> --}}
                        <!-- End Mixitup Nav-->

                        <div class="row magnific-mix-gallery masonary text-light">
                            <div id="portfolio-grid" class="portfolio-items col-3">
                                <div class="pf-item ceremony students">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/1.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Philosophy</h4>
                                            <a href="frontend/gallery/1.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pf-item teachers ceremony">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/2.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Contemporary Art</h4>
                                            <a href="frontend/gallery/2.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pf-item campus education">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/3.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Geometry Course</h4>
                                            <a href="frontend/gallery/3.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pf-item education students">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/4.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Biology Course</h4>
                                            <a href="frontend/gallery/4.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pf-item teachers campus">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/5.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Live Drawing</h4>
                                            <a href="frontend/gallery/5.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="pf-item ceremony teachres">
                                    <div class="item-effect">
                                        <img src="frontend/gallery/6.jpeg" alt="thumb" />
                                        <div class="overlay">
                                            <h4>Informatic Course</h4>
                                            <a href="frontend/gallery/6.jpeg" class="item popup-link"><i
                                                    class="fa fa-plus"></i></a>
                                            <a href="#"><i class="fas fa-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Portfolio -->
@endsection
