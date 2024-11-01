<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>AminPanle</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href={{ asset('admin_assets/img/favicon.ico') }} />
    <link rel="stylesheet" href="{{ asset('admin_assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin_assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>

<body class="theme-white dark-sidebar sidebar-show">
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                                <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        <li>
                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        data-width="200">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">

                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i
                                            class="fas
												fa-bell"></i>
                                    </span> <span class="dropdown-item-desc"> Welcome to Otika
                                        template! <span class="time">Yesterday</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="{{ asset('admin_assets/img/user.png') }}" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title"><b>Hello {{ Auth::user()->name }}</b></div>
                            <a href="{{ route('profile.show') }}" class="dropdown-item has-icon"> <i
                                    class="far
										fa-user"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();  this.closest('form').submit(); " role="button"
                                    class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ url('admin/dashboard') }}">
                            {{-- <img alt="image" src="{{ asset('admin_assets/img/logo.png') }}" class="header-logo" /> --}}
                            <span class="logo-name">নূরানী তা’লীমুল কুরআন বোর্ড বাংলাদেশ</span>

                            {{-- <a href="{{ url('admin/dashboard') }}"> <img alt="image"
                                src="{{ asset('admin_assets/img/logo.png') }}" class="header-logo" />
                        </a> --}}
                    </div>
                    @php
                        $url = Route::current()->uri;
                    @endphp
                    <ul class="sidebar-menu">
                        <br>
                        <li class="dropdown @if ($url == 'admin/dashboard') active @endif ">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                                    class="fas fa-desktop"></i><span>ড্যাশবোর্ড</span></a>
                        </li>

                        <li class="menu-header">ব্যবস্থাপনা বিক্রয়</li>

                        <li class="dropdown @if ($url == 'admin/sell/book') active @endif">
                            <a class="nav-link" href="{{ route('admin.sell.book') }}"><i
                                    class="fas fa-shopping-basket"></i><span>বিক্রেতার কাছে স্থানান্তর</span> </a>
                        </li>


                        {{-- <li class="dropdown @if ($url == 'admin/sell/book') active @endif">
                            <a class="nav-link" href="{{route('admin.sell.book')}}"><i
                                class="fas fa-shopping-basket"></i><span>Sell List</span> </a>
                        </li> --}}




                        <li class="dropdown @if ($url == 'admin/seller/all/info') active @endif">
                            <a class="nav-link" href="{{ route('admin.seller.all.info') }}"><i
                                    class="fas fa-dolly"></i><span>বিক্রেতা সব তথ্য</span> </a>
                        </li>

                        <li class="menu-header">স্টোরেজ ম্যানেজমেন্ট</li>


                        <li class="dropdown @if ($url == 'admin/store/book') active @endif">
                            <a class="nav-link" href="{{ route('admin.store.book') }}"><i
                                    class="fas fa-store-alt"></i><span>স্টোর বই</span> </a>
                        </li>
                        <li class="dropdown @if ($url == 'admin/create/subject') active @endif">
                            <a class="nav-link" href="{{ route('admin.create.subject') }}"><i
                                    class="fas fa-align-center"></i><span>বিষয় তৈরি করুন</span> </a>
                        </li>
                        <li class="dropdown @if ($url == 'admin/create/class') active @endif">
                            <a class="nav-link" href="{{ route('admin.create.class') }}"><i
                                    class="fas fa-address-card"></i><span>ক্লাস তৈরি করুন</span> </a>
                        </li>
                        <li class="dropdown @if ($url == 'admin/storage/alert') active @endif">
                            <a class="nav-link" href="{{ route('admin.storage.alert') }}"><i
                                    class="fas fa-info"></i><span>স্টোরেজ সতর্কতা</span> </a>
                        </li>


                        <li class="dropdown ">
                            <a class="nav-link" href="{{ url('admin/try/to/show/data/new/way') }}"><i
                                    class="fas fa-info"></i><span>New</span> </a>
                        </li>




                        <li class="menu-header">অন্যান্য মেনু</li>

                        <li class="dropdown @if ($url == 'admin/printing/press/all/information' || $url == 'admin/printing/press/filert/information') active @endif">
                            <a class="nav-link" href="{{ route('admin.printing.press.all.information') }}"><i
                                    class="fa fa-podcast" aria-hidden="true"></i><span>প্রিন্টিং প্রেসের
                                    সকল তথ্য</span> </a>
                        </li>

                        <li class="dropdown @if ($url == 'admin/storage/alert') active @endif">
                            <a class="nav-link" href="{{ route('admin.printing.press') }}"><i
                                    class="
                            fas fa-print"></i></i><span>প্রিন্টিং
                                    প্রেস যোগ করুন</span> </a>
                        </li>

                        {{-- <li class="dropdown @if ($url == 'admin/printing/press') active @endif ">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><span>প্রিন্টিং
                                    প্রেস</span></a>
                            <ul class="dropdown-menu">
                                <li class="@if ($url == 'admin/printing/press') active @endif"><a class="nav-link"
                                        href="{{ route('admin.printing.press') }}">Add printing press</a></li>
                                <li><a class="nav-link"
                                        href="{{ route('admin.printing.press.unpaid') }}">অপরিশোধিত</a></li>
                            </ul>
                        </li> --}}



                        <li class="dropdown @if ($url == 'admin/create/user') active @endif ">
                            <a href="{{ route('admin.create.user') }}" class="nav-link">
                                <i class="fas fa-user-plus"></i>
                                <span>ব্যবহারকারী ব্যবস্থাপনা</span></a>
                        </li>

                        <br>
                        <br>

                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">


                @yield('adminpanel-navbar')


            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    <a href="nexiobd.com">NexioBD</a></a>
                </div>
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('admin_assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('admin_assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('admin_assets/js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('admin_assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('admin_assets/js/custom.js') }}"></script>
    <script src="{{ asset('admin_assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin_assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('admin_assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('admin_assets/js/page/datatables.js') }}"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>

</body>

</html>
