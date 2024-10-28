<!-- Header
============================================= -->
<header id="home">

    <!-- Start Navigation -->
    <nav class="navbar navbar-default logo-less small-pad navbar-sticky bootsnav">

        <!-- Start Top Search -->
        <div class="container">
            <div class="row">
                <div class="top-search">
                    <div class="input-group">
                        <form action="#">
                            <input type="text" name="text" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/logo.jpeg" class="logo" alt="Logo">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">

                <a class="d-none d-lg-block" href="/">
                    <img src="/logo.jpeg" alt="logo">
                </a>


                <ul class="nav navbar-nav navbar-left" data-in="#" data-out="#">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">About Us</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('bbr-history') }}">History of the BBR</a></li>
                            <li><a href="{{ url('chairman-msg') }}">Message form Chairman</a></li>
                            <li><a href="{{ url('director-msg') }}">Message Form Director</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Activities</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('training-&-development') }}">Training & Development</a></li>
                            <li><a href="{{ url('research-methodology-training') }}">Research Methodology Training</a>
                            </li>
                            {{-- <li><a href="{{ url('software-training') }}">Software Training</a></li>
                            <li><a href="{{ url('consultancy-and-industrial-problem-solving') }}">Consultancy and
                                    Industrial Problem solving</a></li> --}}
                            <li><a href="{{ url('corporate-training') }}">Corporate Training</a></li>
                            <li><a href="{{ url('ongoing-projects') }}">Ongoing Projects</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Peoples</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('list-of-the-Committee') }}">List of the Committee</a></li>
                            <li><a href="{{ url('chairman-&-director-list') }}">Chairman & Director List</a></li>
                            <li><a href="{{ url('all-staff') }}">Office Staff/Officer</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Research</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('publication') }}">Publications</a></li>
                            <li><a href="{{ url('research-team') }}">Research Team</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Explore</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('all-news') }}">News</a></li>
                            <li><a href="{{ url('all-event') }}">Events</a></li>
                            <li><a href="{{ url('gallery') }}">Gallery</a></li>
                            <li><a href="{{ url('all-notice') }}">Notice</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('contact-us') }}">Contact Us</a>
                    </li>
                    <li>
                        <a href="{{ url('guide-lines') }}">Guidelines</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>
    <!-- End Navigation -->

</header>
<!-- End Header -->
