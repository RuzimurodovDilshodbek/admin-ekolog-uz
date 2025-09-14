@extends("web.layouts.app")



@section("content")

    <!-- Main Breadcrumb Start -->
    <div class="main--breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="home-1.html" class="btn-link"><i class="fa fm fa-home"></i>{{__("Bosh sahifa")}}</a></li>
                <li class="active"><span>{{__("Ustozlar")}}</span></li>
                <li class="active"><span>{{$tutor->fullname}}</span></li>
            </ul>
        </div>
    </div>
    <!-- Main Breadcrumb End -->

    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row" style="transform: none;">
                <!-- Main Content Start -->
                <div class="main--content col-md-8 col-sm-7" data-sticky-content="true"
                     style="position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                    <div class="sticky-content-inner"
                         style="padding-top: 1px; padding-bottom: 1px; position: relative; transform: none;">
                        <!-- Post Author Info Start -->
                        <div class="post--author-info clearfix">
                            <div class="img">
                                <div class="vc--parent">
                                    <div class="vc--child">
                                        <img src="{{$tutor->photo?->url}}" alt="" data-rjs="2">
                                        <p class="name">{{$tutor->fullname}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="info">
                                <h2 class="h4">{{__("Ustoz haqida")}}</h2>

                                <div class="content">
                                    <p>{!! $tutor->about !!}</p>
                                </div>

                                <ul class="social nav">
                                    <li><a href="{{$tutor->facebook}}"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="{{$tutor->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="{{$tutor->gmail}}"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="{{$tutor->rss}}"><i class="fa fa-rss"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Post Author Info End -->


                        @php
                            $chunkedOpinions = $opinions->chunk(4); // Chunk the posts into groups of 4
                        @endphp


                        @foreach($chunkedOpinions as $opinionsItems)

                            <!-- Post Items Start -->
                            <div class="post--items post--items-5 pd--30-0">
                                <ul class="nav">
                                    @foreach($opinionsItems as $opinion)
                                        <li>
                                            <!-- Post Item Start -->
                                            <div class="post--item post--title-larger">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-4 col-xxs-12">
                                                        <div class="post--img">
                                                            <a href="news-single-v1.html" class="thumb"><img
                                                                    src="img/blog-img/post-04.jpg" alt=""></a>
                                                            <a href="#" class="cat">Foods</a>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8 col-sm-12 col-xs-8 col-xxs-12">
                                                        <div class="post--info">
                                                            <ul class="nav meta">
                                                                <li><a href="#">Bune</a></li>
                                                                <li><a href="#">16 April 2016</a></li>
                                                            </ul>

                                                            <div class="title">
                                                                <h3 class="h4"><a href="news-single-v1.html"
                                                                                  class="btn-link">Credibly pontificate
                                                                        highly efficient manufactured products and
                                                                        enabled data.</a></h3>
                                                            </div>
                                                        </div>

                                                        <div class="post--content">
                                                            <p>Et harum quidem rerum facilis est et expedita distinctio.
                                                                Nam libero tempore, cum soluta nobis est eligendi optio
                                                                cumque nihil impedit quo minus id quod maxime placeat
                                                                facere possimus.</p>
                                                        </div>

                                                        <div class="post--action">
                                                            <a href="news-single-v1.html">Continue Reading...</a>
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




                        <!-- Pagination Start -->
                        <div class="pagination--wrapper clearfix bdtop--1 bd--color-2 ptop--60 pbottom--30">
{{--                            <p class="pagination-hint float--left">Page {{ $opinions->currentPage() }}--}}
{{--                                of {{ $opinions->lastPage() }}</p>--}}

                            <ul class="pagination float--right">
                                @if ($opinions->onFirstPage())
                                    <li><span><i class="fa fa-long-arrow-left"></i></span></li>
                                @else
                                    <li><a href="{{ $opinions->previousPageUrl() }}"><i
                                                class="fa fa-long-arrow-left"></i></a></li>
                                @endif

                                @php
                                    $totalPages = $opinions->lastPage();
                                    $currentPage = $opinions->currentPage();
                                @endphp

                                @if ($totalPages > 3 && $currentPage > 1)
                                    <li><a href="{{ $opinions->url(1) }}">1</a></li>
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
                                            <a href="{{ $opinions->url($page) }}">{{ sprintf("%02d", $page) }}</a>
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
                                    <li>
                                        <a href="{{ $opinions->url($totalPages) }}">{{ sprintf("%02d", $totalPages) }}</a>
                                    </li>
                                @endif

                                @if ($opinions->hasMorePages())
                                    <li><a href="{{ $opinions->nextPageUrl() }}"><i
                                                class="fa fa-long-arrow-right"></i></a></li>
                                @else
                                    <li><span><i class="fa fa-long-arrow-right"></i></span></li>
                                @endif
                            </ul>
                        </div>
                        <!-- Pagination End -->


                        <div class="resize-sensor"
                             style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;">
                            <div class="resize-sensor-expand"
                                 style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                                <div
                                    style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 760px; height: 3134px;"></div>
                            </div>
                            <div class="resize-sensor-shrink"
                                 style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
                                <div
                                    style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Content End -->

                @include("web.layouts.sidebar")

            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
