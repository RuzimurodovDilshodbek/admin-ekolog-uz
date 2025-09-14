@extends("web.layouts.app")
@section("content")

    <!-- Main Breadcrumb Start -->
    <div class="main--breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="home-1.html" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>
                <li class="active"><span>{{__("So'ngi")}}</span></li>
            </ul>
        </div>
    </div>
    <!-- Main Breadcrumb End -->

    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row">
                <!-- Main Content Start -->
                <div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
                    <div class="sticky-content-inner">

                        @php
                            $chunkedPosts = $recentPosts->chunk(4); // Chunk the posts into groups of 4
                        @endphp

                        @foreach ($chunkedPosts as $chunk)

                            <!-- Post Items Start -->
                            <div class="post--items post--items-5 pd--30-0">
                                <ul class="nav">
                                    @foreach ($chunk as $post)
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--title-larger">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-4 col-xxs-12">
                                                        <div class="post--img">
                                                            <a href="{{url("news/detail")}}" class="thumb"><img
                                                                    src="img/blog-img/post-01.jpg" alt=""></a>
                                                            <a href="#" class="cat">Kids</a>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8 col-sm-12 col-xs-8 col-xxs-12">
                                                        <div class="post--info">
                                                            <ul class="nav meta">
                                                                <li><a href="#">Bushyasta</a></li>
                                                                <li><a href="#">16 April 2016</a></li>
                                                            </ul>

                                                            <div class="title">
                                                                <h3 class="h4"><a href="{{url("news/detail")}}"
                                                                                  class="btn-link">Credibly
                                                                        pontificate highly efficient manufactured products and
                                                                        enabled data.</a></h3>
                                                            </div>
                                                        </div>

                                                        <div class="post--content">
                                                            <p>Et harum quidem rerum facilis est et expedita distinctio. Nam
                                                                libero tempore, cum soluta nobis est eligendi optio cumque nihil
                                                                impedit quo minus id quod maxime placeat facere possimus.</p>
                                                        </div>

                                                        <div class="post--action">
                                                            <a href="{{url("news/detail")}}">Continue Reading...</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Post Item End -->
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            <!-- Post Items End -->

                            <!-- Advertisement Start -->
                            <div class="ad--space">
                                <a href="#">
                                    <img src="img/ads-img/ad-728x90-02.jpg" alt="" class="center-block">
                                </a>
                            </div>
                            <!-- Advertisement End -->
                        @endforeach



{{--                        {{ $recentPosts->links() }}--}}

                        <!-- Pagination Start -->
                        <div class="pagination--wrapper clearfix bdtop--1 bd--color-2 ptop--60 pbottom--30">
{{--                            <p class="pagination-hint float--left">Page {{ $recentPosts->currentPage() }} of {{ $recentPosts->lastPage() }}</p>--}}

                            <ul class="pagination float--right">
                                @if ($recentPosts->onFirstPage())
                                    <li><span><i class="fa fa-long-arrow-left"></i></span></li>
                                @else
                                    <li><a href="{{ $recentPosts->previousPageUrl() }}"><i class="fa fa-long-arrow-left"></i></a></li>
                                @endif

                                @php
                                    $totalPages = $recentPosts->lastPage();
                                    $currentPage = $recentPosts->currentPage();
                                @endphp

                                @if ($totalPages > 3 && $currentPage > 1)
                                    <li><a href="{{ $recentPosts->url(1) }}">01</a></li>
                                @endif

                                @if ($currentPage > 3)
                                    <li>
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-angle-double-right"></i>
                                    </li>
                                @endif

                                @foreach (range(max(1, $currentPage - 2), min($totalPages, $currentPage + 2)) as $page)
                                    <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                        @if ($page == $currentPage)
                                            <span>{{ sprintf("%02d", $page) }}</span>
                                        @else
                                            <a href="{{ $recentPosts->url($page) }}">{{ sprintf("%02d", $page) }}</a>
                                        @endif
                                    </li>
                                @endforeach

                                @if ($currentPage < $totalPages - 2)
                                    <li>
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-angle-double-right"></i>
                                    </li>
                                @endif

                                @if ($totalPages > 3 && $currentPage < $totalPages)
                                    <li><a href="{{ $recentPosts->url($totalPages) }}">{{ sprintf("%02d", $totalPages) }}</a></li>
                                @endif

                                @if ($recentPosts->hasMorePages())
                                    <li><a href="{{ $recentPosts->nextPageUrl() }}"><i class="fa fa-long-arrow-right"></i></a></li>
                                @else
                                    <li><span><i class="fa fa-long-arrow-right"></i></span></li>
                                @endif
                            </ul>
                        </div>
                        <!-- Pagination End -->
                    </div>
                </div>
                <!-- Main Content End -->
                @include("web.layouts.sidebar")

            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
