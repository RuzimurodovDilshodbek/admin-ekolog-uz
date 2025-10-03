<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ==== Document Title ==== -->
    <title>@yield('title') | Ekolog uz</title>

    <!-- ==== Document Meta ==== -->
    <meta name="author" content="">
    <meta name="title" content="@yield('title')" />
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="@yield('og_type')" />
    <meta property="og:locale" content="{{ app()->getLocale()  }}" />
    <meta property="og:locale:alternate" content="uz" />
    <meta property="og:site_name" content="Ekolog uz" />
    <meta property="og:image" content="@yield('og_image')" />

    <!-- ==== Favicons ==== -->
    <link rel="icon" href="{{ asset('img/ico.png') }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />

    <!-- fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="{{asset("scss/style.css")}}">
{{--    <link rel="stylesheet" href="{{asset("bootstrap/dist/css/bootstrap.min.css")}}">--}}
{{--    <link rel="stylesheet" href="{{asset("scss/style.scss")}}">--}}

    <link rel="stylesheet" href="{{asset("css/fix-style.css")}}">


{{--    <!-- ==== Font Awesome ==== -->--}}
    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">



    @stack("headStyles")

    @stack("headScripts")
    <![endif]-->
</head>
<body>

<!-- Preloader Start -->
<div id="preloader">
    <div class="preloader bg--color-1--b" data-preloader="1">
        <div class="preloader--inner"></div>
    </div>
</div>
<!-- Preloader End -->

<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Header Section Start -->
    @include("web.layouts.header")
    <!-- Header Section End -->

    @yield("content")

    <!-- Footer Section Start -->
    @include("web.layouts.footer")
    <!-- Footer Section End -->
</div>


<!-- Back To Top Button Start -->
<div id="backToTop">
    <a href="#"><i class="fa fa-angle-double-up"></i></a>
</div>

<!-- ==== Bootstrap Framework ==== -->
<script src="{{asset("js/bootstrap.min.js")}}"></script>

<script src="{{ asset('/js/main2.js')  }}"></script>

<!-- Back To Top Button End -->

<!-- ==== jQuery Library ==== -->
<script src="{{asset("js/jquery-3.2.1.min.js")}}"></script>


<!-- ==== StickyJS Plugin ==== -->
<script src="{{asset("js/jquery.sticky.min.js")}}"></script>
<!-- ==== HoverIntent Plugin ==== -->
<script src="{{asset("js/jquery.hoverIntent.min.js")}}"></script>

<!-- ==== Marquee Plugin ==== -->
<script src="{{asset("js/jquery.marquee.min.js")}}"></script>

<!-- ==== Validation Plugin ==== -->
<script src="{{asset("js/jquery.validate.min.js")}}"></script>

<!-- ==== Isotope Plugin ==== -->
<script src="{{asset("js/isotope.min.js")}}"></script>

<!-- ==== Resize Sensor Plugin ==== -->
<script src="{{asset("js/resizesensor.min.js")}}"></script>

<!-- ==== Sticky Sidebar Plugin ==== -->
<script src="{{asset("js/theia-sticky-sidebar.min.js")}}"></script>

<!-- ==== Zoom Plugin ==== -->
<script src="{{asset("js/jquery.zoom.min.js")}}"></script>

<!-- ==== Bar Rating Plugin ==== -->
<script src="{{asset("js/jquery.barrating.min.js")}}"></script>

<!-- ==== Countdown Plugin ==== -->
<script src="{{asset("js/jquery.countdown.min.js")}}"></script>

<!-- ==== RetinaJS Plugin ==== -->
<script src="{{asset("js/retina.min.js")}}"></script>

<!-- ==== Main JavaScript ==== -->
<script src="{{asset("js/mainfront.js")}}"></script>

<!-- carusel -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
{{--<script src="main.js"></script>--}}


@yield("footerScripts")

</body>
</html>
