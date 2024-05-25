@extends('adminPanel/navbar')

@section('adminpanel-navbar')
@php
 use App\Models\Subjects;
 use App\Models\StoreBook;
 use App\Models\Classes;
 use App\Models\PrintingPress;

@endphp
    <div class="row ">

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h1 class="font-15">Total press</h1>
                                    <h2 class="mb-3 font-18">{{PrintingPress::count()}}</h2>
                                    {{-- <p class="mb-0">printing <span class="col-green">  </span></p> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <a href="{{url('admin/printing/press')}}">
                                <div class="banner-img">
                                    <img src="{{asset('admin_assets/img/banner/1.png')}}" alt="">
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15"> Total Books</h5>
                                    <h2 class="mb-3 font-18">{{StoreBook::count()}}</h2>
                                    {{-- <p class="mb-0"><span class="col-orange"></span></p> --}}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <a href="{{url('admin/store/book')}}">
                                <div class="banner-img">
                                    <img src="{{asset('admin_assets/img/banner/2.png')}}" alt="">
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Total Class</h5>
                                    <h2 class="mb-3 font-18">{{Classes::count()}}</h2>
                                    {{-- <p class="mb-0"><span class="col-green">18%</span>
                                        Increase</p> --}}
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <a href="{{url('admin/create/class')}}">
                                <div class="banner-img">
                                    <img src="{{asset('admin_assets/img/banner/3.png')}}" alt="">
                                </div>
                            </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Total Subject</h5>
                                    <h2 class="mb-3 font-18">{{Subjects::count()}}</h2>
                                    {{-- <p class="mb-0"><span class="col-green">42%</span> Increase</p> --}}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <a href="{{url('admin/create/subject')}}">
                                <div class="banner-img">
                                    <img src="{{asset('admin_assets/img/banner/4.png')}}" alt="">
                                </div>
                            </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
