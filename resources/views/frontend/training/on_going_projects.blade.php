@extends('frontend.layouts.app')
@section('content')
    <!-- Start Breadcrumb
                                                                                                                                                                                                                                                                                                            ============================================= -->
    <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
        style="background-image: url(frontend/2022-04-22.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2><b>On Going Project</b></h2>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="#">Activities</li>
                        <li class="active">On Going Project</li>
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
                    <!-- Start Sidebar -->
                    {{-- <div class="sidebar col-md-3">
                        <aside>
                            <div class="sidebar-item recent-post">
                                <div class="title">
                                    <h4>Department of BBR</h4>
                                </div>
                                <div style="max-height: 450px; overflow-y: auto">
                                    <ul>

                                        <li>
                                            <div class="info">
                                                <a href="">Bhishmadeb Choudhury  Professor <br>( LPR )</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="info">
                                                <a href="">Fatema Kawser <br> Professor & Chairman</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="info">
                                                <a href="">Serajul Islam (Seraj Salekeen) <br> Professor</a>
                                            </div>
                                        </li>
                                        <div class="text-center">
                                            <a href="{{ url('all-event') }}" class="btn btn-theme effect btn-md"> View
                                                All</a>
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
                                            <a href="all-notice">Notice <span>69</span></a>
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
                    </div> --}}
                    <!-- End Start Sidebar -->
                    {{-- <div class="blog-content col-md-8">

                        <article style="color: #000;">
                            <h2 style="font-family: Times New Roman; font-size: 20px;">About the Journal </h2>

                            <p
                                style="text-align: justify;  font-family: Times New Roman; font-size: 13px; line-height: 20px;">
                                The Journal of Business Studies focuses on facilitating the exchange of scholarly knowledge
                                between academics, industry stakeholders and the regulators across the world in the field of
                                finance.
                                <br>
                                The journal welcomes original research articles, reviews, and industry insights related to
                                finance and investment, governance, financial institutions, money and capital markets, and
                                the interlinks between financial markets and the economy at the country, regional, and world
                                level.

                                <br>
                                Journal of Business Studies is officially published and supported by the Faculty of Business
                                Studies, University of Dhaka – Bangladesh’s only state-run specialized institute for
                                offering academic degree programs, training and research in areas related to financial
                                markets.

                            </p>


                        </article>

                        <article>
                            <h2 style="Text-align: justify;  font-family: Times New Roman; font-size: 20px; color:#000;">
                                Featured</h2>
                            <p>

                            </p>
                            <table>
                                <tbody>
                                    <tr>
                                        <td> <img src="frontend/molart1st.jpg" style="width:200px; height: 220px;"></td>
                                        <td valign="top" style="padding: 10px;">
                                            <p
                                                style="Text-align: justify;  font-family: Times New Roman; font-size: 13px; line-height:22px; color:#000;">
                                                <a href=""
                                                    style="Text-align: justify;  font-family: Times New Roman; font-size: 13px; line-height:22px;">Sepecial
                                                    Edition 3rd International Conference on Business and Economics -2020</a>
                                                <br>
                                                Special International Edition

                                                <br>
                                                <a href="https://www.fbs-du.com/jdetails.php?jid=18" target="_blank"
                                                    style="Text-align: justify;  font-family: Times New Roman; font-size: 15px;">Click
                                                    here for submission</a>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>



                            <p></p>
                        </article>
                        <nav>

                        </nav>

                        <article>
                            <h2 style="Text-align: justify;  font-family: Times New Roman; font-size: 20px; color: #000;">
                                Articles</h2>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true"
                                    style="Text-align: justify;  font-family: Times New Roman; font-size: 17px; color: #000;">Most
                                    Recent</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false"
                                    style="Text-align: justify;  font-family: Times New Roman; font-size: 17px; color: #000;">Most
                                    Viewed</a>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">

                                    <article>
                                        <p style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;"><a
                                                href="https://www.fbs-du.com/jdetails.php?jid=23" target="_blank"
                                                style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;">Journal
                                                of Business Studies, Vol. XL, No. 3, December 2019</a> <br>
                                            <span style="color: #000; font-size: 13px;">

                                                Published date: December 2019
                                            </span>
                                        </p>
                                        <p> <a href="https://www.fbs-du.com/jdetails.php?jid=23" target="_blank"><button
                                                    style="width: 80px; border: none; height: 35px; background: #005274; color: #fff;">PDF</button>
                                            </a> </p>
                                    </article>

                                    <article>
                                        <p style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;"><a
                                                href="https://www.fbs-du.com/jdetails.php?jid=22" target="_blank"
                                                style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;">Journal
                                                of Business Studies, Vol. XL, No. 2, August 2019</a> <br>
                                            <span style="color: #000; font-size: 13px;">

                                                Published date: August 2019
                                            </span>
                                        </p>
                                        <p><a href="https://www.fbs-du.com/jdetails.php?jid=22" target="_blank"><button
                                                    style="width: 80px; border: none; height: 35px; background: #005274; color: #fff;">PDF</button>
                                            </a> </p>
                                    </article>


                                    <article>
                                        <p style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;"><a
                                                href="https://www.fbs-du.com/jdetails.php?jid=21" target="_blank"
                                                style="Text-align: justify;  font-family: Times New Roman; font-size: 13px;">Journal
                                                of Business Studies, Vol. XL, No. 1, April 2019</a> <br>
                                            <span style="color: #000; font-size: 13px;">

                                                Published date: April 2019
                                            </span>
                                        </p>
                                        <p><a href="https://www.fbs-du.com/jdetails.php?jid=21" target="_blank"><button
                                                    style="width: 80px; border: none; height: 35px; background: #005274; color: #fff;">PDF</button>
                                            </a> </p>
                                    </article>


                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <p>No data available</p>
                                </div>
                            </div>
                        </article>



                    </div> --}}

                    <div class="blog-content col-md-12 text-justify">


                        <article>
                            <h2 style="text-align: center; padding:20px;  color:#000;">
                                On Going Project</h2>
                            <hr>
                            <p>

                            </p>
                            <table class="table table-bordered" style="font-size: 17px;">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.No</th>
                                        <th scope="col">Project No & Date of Agreement</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Name of the Project Leader</th>
                                        <th scope="col">Title of the Project</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>176
                                            13-03-2013 </td>
                                        <td>1 Year</td>
                                        <td>Mr. Al-Amin, AIS
                                            &
                                            Saiful Alam
                                        </td>
                                        <td>Accounting Quality Governance and Efficiency Evidence from Dhaka Stock Market.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>179
                                            10-02-2015 </td>
                                        <td>1 Year</td>
                                        <td>Dr. Mohammad Tareq, AIS
                                        </td>
                                        <td>Tunneling though Retaining Dividends: Evidence from Listed Companies of
                                            Bangladesh.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>180
                                            10-05-2015 </td>
                                        <td>1 Year</td>
                                        <td>Prof. Haripada Bhattacharjee, Marketing
                                        </td>
                                        <td>Export Potentiality of Pharmaceutical Products from Bangladesh.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>188
                                            24-07-2018</td>
                                        <td>1 Year</td>
                                        <td>Koushik Prashad Pathak
                                            &
                                            Abureza M Muzareba, Marketing
                                        </td>
                                        <td>A Strategic approach to sustainable archaeological tourism development: A Study
                                            on Kantaji.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>189
                                            28-09-2018 </td>
                                        <td>1 Year</td>
                                        <td>Moshahida Sultana, AIS
                                        </td>
                                        <td>Political Economy of clean Energy Transition: The case of Bangladesh.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>190
                                            28-09-2019</td>
                                        <td>1 Year</td>
                                        <td>Md. Kamruzzaman, THM
                                        </td>
                                        <td>Technology Improved Co-creation of Customer Experience: An Empirical Study on
                                            the Tourism Industry of Bangladesh.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>191
                                            11-12-2018</td>
                                        <td>1 Year</td>
                                        <td>Md. Jamil Sharif, AIS
                                        </td>
                                        <td>Child Day Care Center (CDC): A Potential Business Segment for the woman
                                            Entrepreneurs in Dhaka City.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>193
                                            01-01-2019</td>
                                        <td>1 Year</td>
                                        <td>Dr. Md.Saiful Alam, AIS
                                        </td>
                                        <td>Role of Professional Accountant in NGO Accountability.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>197
                                            17-04-2022</td>
                                        <td>1 Year</td>
                                        <td>Mollika Ghosh
                                            &
                                            Prof. Dr.ABM Shahidul Islam, Marketing
                                        </td>
                                        <td>Influencer Marketing Investigating its Impact on Urban Millennial Consumers
                                            Engagement with Facebook Advertising.
                                        </td>
                                        <td>on going</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">10</th>
                                        <td>199
                                            20-07-2022</td>
                                        <td>1 Year</td>
                                        <td>Prof. Dr. Muhammad Shariat Ullah
                                            &
                                            Dr. Md. Rakibul Hoque
                                            &
                                            Md. Rashedur Rahman, OSL
                                        </td>
                                        <td>Information and Communication Technology (ICT) Adoption of SMEs in Bangladesh.

                                        </td>
                                        <td>on going</td>
                                    </tr>



                                </tbody>
                            </table>

                            <p></p>
                        </article>

                    </div>
                </div>


            </div>

        </div>
    </div>
    </div>

    <!-- End Blog -->
@endsection
