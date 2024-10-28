@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
                                                                                                                                                                                                                                                                                                                    ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>Guidelines</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#">Page</a></li>
                        <li class="active">Guidelines</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start 404
                                                                                                                                
                                                                                                                                                                                                                                                                                                                    ============================================= -->

    <div class="error-page-area default-padding">
        <div class="container">
            <div class="error-items">
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <article style="color: #000; text-align:center;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="">
                                            <th scope="col">
                                                <center> #</center>
                                            </th>
                                            <th scope="col">
                                                <center>Title</center>
                                            </th>
                                            <th scope="col">
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>বের মধ্যে সবচেয়ে সম্পূর্ণতা মানুষের। কিন্তু সবচেয়ে অসম্পূর্ণ হয়ে সে
                                                জন্মগ্রহণ করে। বাঘ ভালুক তার জীবনযাত্রার পনেরো- আনা মূলধন নিয়ে আসে প্রকৃতির
                                                মালখানা থেকে। জীবরঙ্গভূমিতে মানুষ এসে দেখা দেয় দুই শূন্য হাতে মুঠো বেঁধে।
                                            </td>
                                            <td><a href="https://ssl.du.ac.bd/fontView/images/noc/17289138239114.pdf"
                                                    class="btn btn-theme effect btn-md"><i class="fa fa-download"
                                                        aria-hidden="true"></i></a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>বহুকাল হইলো আমি একবার পালামৌ প্রদেশে গিয়াছিলাম,
                                                প্রত্যাগমন করিলে পর সেই অঞ্চলের বৃত্তান্ত লিখিবার নিমিত্ত দুই-এক জন
                                                বন্ধুবান্ধব আমাকে পুনঃপুন অনুরোধ করিতেন,
                                                আমি তখন তাঁহাদের উপহাস করিতাম।
                                            </td>
                                            <td><a href="#" class="btn btn-theme effect btn-md"><i
                                                        class="fa fa-download" aria-hidden="true"></i></a></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </article>
                        </center>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End 404 -->
@endsection
