@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
                                                                                                                                                                                                                            ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>Message From Director</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li> --}}
                        {{-- <li><a href="#">About Us</a></li> --}}
                        {{-- <li class="active">Message From Director</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Blog
                                                                                                                                                                                                                            ============================================= -->
    <div class="blog-area single full-blog full-blog default-padding">
        <div class="container">
            <div class="row">
                <div class="blog-items">
                    <div class="blog-content col-md-4" style="margin-top: 30px;">
                        <div class="single-item">
                            <div class="item">
                                <!-- Start Post Thumb -->
                                <div class="thumb">
                                    <a href="#">
                                        <img src="frontend/director.jpg" alt="Thumb" style="padding-left: 30px;">
                                    </a>
                                </div>
                                <!-- Start Post Thumb -->
                            </div>
                            <center>
                                <div class="content">
                                    <h3><b>Dr. ABM Shahidul Islam</b></h3>
                            </center>
                        </div>
                    </div>
                    <div class="blog-content col-md-8">
                        <div class="info">

                            <div class="content" style="text-align: justify;">
                                <h3>
                                    Director Message
                                </h3>

                                <p>

                                    I am privileged to work in collaboration with a galaxy of outstandingly successful and
                                    competent academics in the Department of Marketing (DoM), University of Dhaka (DU). It
                                    can
                                    be stated indubitably that the DoM is one of the major sections of academic activity,
                                    under
                                    the Faculty of Business Studies, University of Dhaka. The DU distinct sphere of
                                    knowledge
                                    and expertise, in all likelihood, might be credited with possessing highly qualified and
                                    experienced faculties, a particular group of experts who are scholarly and
                                    wholeheartedly
                                    involved in dedicating incalculable efforts to ensure quality education for
                                    students—enrolled at different programs, offered under the Department. All the academic
                                    programs are facilitated with modern classrooms, containing the state-of-the-art
                                    equipment
                                    encompassing multimedia, digital board, internet network, Wi-Fi services, modern sound
                                    system, sophisticated Computer Lab and the like. Prioritizing continual innovation and
                                    interactive learning inside the classroom is viewed to be a prime concern to the
                                    programs, a
                                    strategy that is likely to contribute to the nation-building tasks.

                                    The caring attitude of the faculties substantively proves effective in working in
                                    conformity
                                    with the needs and priorities of the student population. The simply discoverable
                                    attribute
                                    of the hard-working faculties can be best explained by illustrating relentless efforts
                                    they
                                    make to impregnate the consciousness of learners with the glimpses of knowledge, tools
                                    and
                                    techniques, so that they can meet any likely challenge in the future to come at national
                                    and
                                    international level. One of the prime objectives of the Department includes bringing the
                                    intrinsic talent out of the students, letting the future leadership of corporate world
                                    fall
                                    upon them. It is notable that the DoM, in harmony with the ever-changing, evolutionary,
                                    and
                                    dynamic nature of marketing, incorporated certain state-of-the-art courses such as
                                    Marketing
                                    Analytics, Digital Marketing and the like in its course curriculum in order to update
                                    the
                                    students on the cutting-edge knowledge and skills.

                                    The DoM offers an adequate number of scholarships for meritorious and financially
                                    challenged
                                    students. Moreover, it arranges seminars, symposiums and workshops on current issues of
                                    marketing on a regular basis, and invites accomplished corporate icons and personalities
                                    to
                                    participate in the events. The matter of fact is that those celebrated personalities
                                    share
                                    their experience from the real-life situations with students and give birth to an
                                    enabling
                                    environment for them to obtain practical knowledge and hands-on experience. The
                                    resourceful
                                    status of the DoM is attributable to the functioning of “Marketing Alumni Association”
                                    (MAA), an apex organization of the Department. MAA has been playing an active role in
                                    offering many a scholarship for the students of the Department, placing them for
                                    internships
                                    in various reputed companies across the country and sponsoring several programs
                                    involving
                                    freshers’ orientation; job fair; sales fair, etc. held under the auspices of the DoM.

                                    I find the glimmer of hope that all those—whose academic upbringing is cropping up
                                    within
                                    the womb of the DoM—will achieve plenty of scope to build an insight into the vast
                                    implications of marketing, a systematically developed conceptual framework, which, as
                                    one of
                                    the major presuppositions of entrepreneurial development leads to success, glory, and
                                    power,
                                    being achieved in the context of universal human situations.

                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Blog -->
@endsection
