@extends("web.layouts.app")



@section("content")

    <!-- Main Breadcrumb Start -->
    <div class="main--breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="home-1.html" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>
                <li class="active"><span>Tutors</span></li>
            </ul>
        </div>
    </div>
    <!-- Main Breadcrumb End -->

    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <!-- Main Content Start -->
            <div class="main--content">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <!-- Page Title Start -->
                        <div class="page--title pd--30-0 text-center">
                            <h2 class="h2">Ustozlarimiz</h2>

                            <div class="content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>

                            <div class="action">
                                <a href="{{url("contact")}}" class="btn btn-primary">Ustoz bo'lish</a>
                            </div>
                        </div>
                        <!-- Page Title End -->
                    </div>
                </div>

                <!-- Contributor Items Start -->
                <div class="contributor--items ptop--30">
                    <ul class="nav row AdjustRow" style="position: relative; height: 459.133px;">
                        @foreach($tutors as $tutor)

                            <li class="col-md-3 col-xs-6 col-xxs-12 pbottom--30"
                                style="position: absolute; left: 0px; top: 0px;">
                                <!-- Contributor Item Start -->
                                <div class="contributor--item style--2">
                                    <div class="img">
                                        <img src="{{$tutor->photo?->url}}" alt="" data-rjs="2">

                                        <ul class="social nav bg--color-1--b">
                                            <li><a href="{{$tutor->facebook}}"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="{{$tutor->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="{{$tutor->gmail}}"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="{{$tutor->rss}}"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                    </div>

                                    <div class="name">
                                        <h3 class="h4">{{$tutor->fullname}}</h3>
                                    </div>

                                    <div class="desc">
                                        <p>{{strip_tags(trim(substr($tutor->about,20)))}}...</p>
                                    </div>

                                    <div class="action">
                                        <a href="{{$tutor->url}}" class="btn btn-default">{{__("Ustoz fikrlari")}}</a>
                                    </div>
                                </div>
                                <!-- Contributor Item End -->
                            </li>

                        @endforeach
                    </ul>
                </div>
                <!-- Contributor Items End -->
            </div>
            <!-- Main Content End -->
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
