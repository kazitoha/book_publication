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
                        <a href="{{url('admin/dashboard')}}"> <img alt="image" src="{{ asset('admin_assets/img/logo.png') }}"
                                class="header-logo" /> <span class="logo-name">Otika</span>
                        </a>
                    </div>
                    @php
                        $url = Route::current()->uri;
                    @endphp
                    <ul class="sidebar-menu">
                        {{-- <li class="menu-header"></li> --}}
                        <br>
                        <li class="dropdown @if ($url == 'admin/dashboard') active @endif ">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                                    data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>

                        <li class="dropdown @if ($url == 'admin/store/book'||$url == 'admin/create/subject' || $url == 'admin/create/class') active @endif">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="shopping-bag"></i><span>Storage management</span></a>
                            <ul class="dropdown-menu">

                              <li class="@if ($url == 'admin/store/book') active @endif"><a class="nav-link" href="{{ route('admin.store.book') }}">Store book </a></li>
                              <li class="@if ($url == 'admin/create/subject') active @endif"><a class="nav-link" href="{{ route('admin.create.subject') }}">Create subject</a></li>
                              <li class="@if ($url == 'admin/create/class') active @endif"><a class="nav-link" href="{{ route('admin.create.class') }}">Create class</a></li>
                              <li class="@if ($url == 'admin/storage/alert') active @endif"><a class="nav-link" href="{{route('admin.storage.alert')}}">Storage alert</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="dollar-sign"></i><span>Account management</span></a>
                            <ul class="dropdown-menu">
                              <li><a class="nav-link" href="{{route('admin.account.create')}}">Account</a></li>
                              <li><a class="nav-link" href="{{route('admin.account.deposit')}}">Deposit</a></li>
                              <li><a class="nav-link" href="{{route('admin.account.expense')}}">Expense</a></li>
                              <li><a class="nav-link" href="{{route('admin.account.expense.category')}}">Expense Category</a></li>
                            </ul>
                        </li>



                        <li class="dropdown @if ($url == 'admin/create/selller' ||  $url == 'admin/books/transfer/to/selller') active @endif">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="briefcase"></i><span>Seller management</span></a>
                            <ul class="dropdown-menu">
                                <li class="@if ($url == 'admin/create/selller') active @endif"><a class="nav-link" href="{{route('admin.create.seller')}}">Add seller</a></li>
                                <li class="@if ($url == 'admin/sell/book') active @endif"><a class="nav-link" href="{{route('admin.sell.book')}}"> Sell Book</a></li>
                              <li><a class="nav-link" href="widget-data.html">Refund request</a></li>
                            </ul>
                        </li>

                        <li class="dropdown @if ($url == 'admin/printing/press') active @endif ">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="printer"></i><span>Printing Press</span></a>
                            <ul class="dropdown-menu">
                              <li class="@if ($url == 'admin/printing/press') active @endif"><a class="nav-link" href="{{ route('admin.printing.press') }}">Add printing press</a></li>
                              <li><a class="nav-link" href="{{route('admin.printing.press.unpaid')}}">Unpaid</a></li>
                            </ul>
                        </li>

                        <li class="dropdown @if ($url == 'admin/create/user') active @endif ">
                            <a href="{{ route('admin.create.user') }}" class="nav-link">
                                <i data-feather="user"></i>
                                <span>User Management</span></a>
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
                    <a href="templateshub.net">Templateshub</a></a>
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
