@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
            ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>History of the Bureau of Business Research<b></h2>
                    {{-- <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li class="active">History of the BBR</li>
                    </ul> --}}
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
                    <div class="blog-content col-md-5" style="margin-top: 30px;">
                        <div class="single-item">
                            <div class="item">
                                <!-- Start Post Thumb -->
                                <div class="thumb">
                                    <a href="#">
                                        <img src="{{ asset('frontend/WhatsApp Image 2024-10-27 at 5.30.51 PM.jpeg') }}"
                                            alt="Thumb">
                                    </a>

                                </div>

                                <!-- Start Post Thumb -->
                            </div>

                        </div>
                    </div>
                    <div class="blog-content col-md-7">
                        <div class="info">

                            <div class="content" style="text-align: justify;">

                                <p>


                                    Established as a specialised business research arm/wing of the Faculty of Business
                                    Studies, University of Dhaka; the Bureau of Business Research (BBR) has emerged as a
                                    pioneer institution for research in the areas of industry, trade and commerce. The
                                    establishment of such a research organisation was greatly felt in the late 1960’s and
                                    the idea was finally accepted with the elevating of Commerce Department into a Faculty
                                    in 1970. After the independence in 1971, the field of business research got heightened
                                    importance. The Faculty members in a meeting on January 1, 1972 agreed to float a
                                    “Bureau of Business Research” in the Faculty. A committee consisting of four members
                                    including Dr. M. Habibullah, Dr. A.H.M. Habibur Rahman, Dr.M. Afzalur Rahim, and Mr. M.
                                    Nasiruddin, was formed in January 1972 to prepare the draft constitution of the proposed
                                    Bureau. The constitution was approved by the Faculty members in a meeting held on
                                    January 11, 1972. Initially a small Executive Committee was formed to run the affairs of
                                    the Bureau with the following members: Dr.A. Farouk, Dr. M. Habibullah and Dr.
                                    A.H.M.Habibur Rahman.

                                    A committee of experts formed by the Vice Chancellor recommended the formal
                                    establishment of the Bureau. The Syndicate formally approved the recommendations, and
                                    BBR came into existence officially in February, 1974. The BBR aims at promoting research
                                    in business areas, undertaking research projects sponsored by the Government and other
                                    private sector agencies; encouraging cross-fertilisation of ideas and knowledge among
                                    the business community, business educators and researchers of Bangladesh and abroad
                                    through seminars, symposia and conferences, assisting organisations through providing
                                    management consulting services, organising training courses on research methodology and
                                    on business areas.

                                    1.2. Financing

                                    The Bureau after becoming a legal organ of the University in 1974, is regularly financed
                                    by
                                    the authority from its Annual Development Plan and recurring grants. In addition to
                                    University
                                    grants, it also receives funds from sources like Government and non-government agencies,
                                    and international organisations.

                                    1.3 Facilities

                                    The Bureau is now located at the 8th floor of the MBA Bhaban (Eastern Eing) covering
                                    approximately an area of 2000 sft. The space is divided into four rooms that include
                                    director’s office, chairman’s office, secretary’s office, office assistant’s room and a
                                    separate room for photocopier and typewriters.
                                    The BBR has a library with rich collections of useful reference books on research
                                    techniques and business related subjects. The materials are available for the
                                    researchers on request. It has access to various facilities such as University Central
                                    Library, Xerox machines, and E- library. In early 1997, the BBR has developed its own
                                    computer facilities.

                                    1.4 Operation of Research Work

                                    The teachers of the Faculty of Business Studies are the research personnel of the
                                    Bureau. Over one hundred teachers, mostly trained abroad, have specialisation in
                                    management, marketing, accounting, finance & banking, insurance, MIS, small enterprise
                                    development, micro credit management and micro enterprise promotion, etc. They accept
                                    the responsibility of conducting research projects not only from the Bureau but also
                                    from the Government and Private agencies and international organisations.

                                    1.5 Staff

                                    The Bureau of Business Research has four full time staff, in addition to the honorary
                                    Chairman and Director. The staff includes Principal Secretary, Head Assistant, Senior
                                    Syclo: Mach operator, and one office Assistant.
                                </p>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->
@endsection
