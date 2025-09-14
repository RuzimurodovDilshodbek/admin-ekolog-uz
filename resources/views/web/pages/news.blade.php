@extends("web.layouts.app")


@php

    $breadCrumbs = [
        [
            "label"=>$section->title
        ]
    ];

@endphp

@section("content")

    <!-- Main Breadcrumb Start -->
    @include("web.layouts.breadcrumb",[
        "breadcrumbs"=>$breadCrumbs
    ])
    <!-- Main Breadcrumb End -->

    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row">
                <!-- Main Content Start -->
                <div class="main--content col-md-8 col-sm-7" data-sticky-content="true">
                    <h3 class="list-title"><b>{{ !empty($search) ? $search : $section->title}}</b></h3>


                    <div class="sticky-content-inner">
                        @php
                            $chunkedPosts = $posts->chunk(4); // Chunk the posts into groups of 4
                        @endphp
                    @if(count($posts) > 0)

                        @foreach ($chunkedPosts as $chunk)
                            <!-- Post Items Start -->
                            <div class="post--items post--items-5 pd--30-0">
                                <ul class="nav">
                                    @foreach ($chunk as $post)
                                        <li>
                                            @include("web.pages.post.post-item",compact("post"))
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Post Items End -->
                            @if(isset($ads[$loop->index]))
                                <!-- Advertisement Start -->
                                <div class="ad--space">
                                    <a href="{{$ads[$loop->index]->url}}">
                                        <img src="{{$ads[$loop->index]->image?->url}}" alt="" class="center-block">
                                    </a>
                                </div>
                                <!-- Advertisement End -->
                            @endif
                        @endforeach
                            <div class="pagination--wrapper clearfix bdtop--1 bd--color-2 ptop--60 pbottom--30">
                                {{--                            <p class="pagination-hint float--left">Page {{ $posts->currentPage() }}--}}
                                {{--                                of {{ $posts->lastPage() }}</p>--}}

                                <ul class="pagination float--right">
                                    @if ($posts->onFirstPage())
                                        <li><span><i class="fa fa-long-arrow-left"></i></span></li>
                                    @else
                                        <li><a href="{{ $posts->previousPageUrl() }}"><i
                                                    class="fa fa-long-arrow-left"></i></a></li>
                                    @endif

                                    @php
                                        $totalPages = $posts->lastPage();
                                        $currentPage = $posts->currentPage();
                                    @endphp

                                    @if ($totalPages > 3 && $currentPage > 1)
                                        <li><a href="{{ $posts->url(1) }}">1</a></li>
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
                                                <a href="{{ $posts->url($page) }}">{{ sprintf("%02d", $page) }}</a>
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
                                            <a href="{{ $posts->url($totalPages) }}">{{ sprintf("%02d", $totalPages) }}</a>
                                        </li>
                                    @endif

                                    @if ($posts->hasMorePages())
                                        <li><a href="{{ $posts->nextPageUrl() }}"><i
                                                    class="fa fa-long-arrow-right"></i></a></li>
                                    @else
                                        <li><span><i class="fa fa-long-arrow-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                    @else
                            <div
                                class="post--item post-list post--title-larger ">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-xxs-12">
                                        <div>
                                            <div class="el-empty">
                                                <div class="el-empty__image">
                                                    <svg viewBox="0 0 79 86" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="linearGradient-1-1" x1="38.8503086%" y1="0%" x2="61.1496914%" y2="100%"><stop stop-color="#FCFCFD" offset="0%"></stop><stop stop-color="#EEEFF3" offset="100%"></stop></linearGradient><linearGradient id="linearGradient-2-1" x1="0%" y1="9.5%" x2="100%" y2="90.5%"><stop stop-color="#FCFCFD" offset="0%"></stop><stop stop-color="#E9EBEF" offset="100%"></stop></linearGradient><rect id="path-3-1" x="0" y="0" width="17" height="36"></rect></defs><g id="Illustrations" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="B-type" transform="translate(-1268.000000, -535.000000)"><g id="Group-2" transform="translate(1268.000000, 535.000000)"><path id="Oval-Copy-2" d="M39.5,86 C61.3152476,86 79,83.9106622 79,81.3333333 C79,78.7560045 57.3152476,78 35.5,78 C13.6847524,78 0,78.7560045 0,81.3333333 C0,83.9106622 17.6847524,86 39.5,86 Z" fill="#F7F8FC"></path><polygon id="Rectangle-Copy-14" fill="#E5E7E9" transform="translate(27.500000, 51.500000) scale(1, -1) translate(-27.500000, -51.500000) " points="13 58 53 58 42 45 2 45"></polygon><g id="Group-Copy" transform="translate(34.500000, 31.500000) scale(-1, 1) rotate(-25.000000) translate(-34.500000, -31.500000) translate(7.000000, 10.000000)"><polygon id="Rectangle-Copy-10" fill="#E5E7E9" transform="translate(11.500000, 5.000000) scale(1, -1) translate(-11.500000, -5.000000) " points="2.84078316e-14 3 18 3 23 7 5 7"></polygon><polygon id="Rectangle-Copy-11" fill="#EDEEF2" points="-3.69149156e-15 7 38 7 38 43 -3.69149156e-15 43"></polygon><rect id="Rectangle-Copy-12" fill="url(#linearGradient-1-1)" transform="translate(46.500000, 25.000000) scale(-1, 1) translate(-46.500000, -25.000000) " x="38" y="7" width="17" height="36"></rect><polygon id="Rectangle-Copy-13" fill="#F8F9FB" transform="translate(39.500000, 3.500000) scale(-1, 1) translate(-39.500000, -3.500000) " points="24 7 41 7 55 -3.63806207e-12 38 -3.63806207e-12"></polygon></g><rect id="Rectangle-Copy-15" fill="url(#linearGradient-2-1)" x="13" y="45" width="40" height="36"></rect><g id="Rectangle-Copy-17" transform="translate(53.000000, 45.000000)"><mask id="mask-4-1" fill="white"><use xlink:href="#path-3-1"></use></mask><use id="Mask" fill="#E0E3E9" transform="translate(8.500000, 18.000000) scale(-1, 1) translate(-8.500000, -18.000000) " xlink:href="#path-3-1"></use><polygon id="Rectangle-Copy" fill="#D5D7DE" mask="url(#mask-4-1)" transform="translate(12.000000, 9.000000) scale(-1, 1) translate(-12.000000, -9.000000) " points="7 0 24 0 20 18 -1.70530257e-13 16"></polygon></g><polygon id="Rectangle-Copy-18" fill="#F8F9FB" transform="translate(66.000000, 51.500000) scale(-1, 1) translate(-66.000000, -51.500000) " points="62 45 79 45 70 58 53 58"></polygon></g></g></g></svg>
                                                </div>
                                                <div class="el-empty__description"><p>{{__("home.Маълумот мавжуд эмас")}}</p></div><!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif

                    </div>
                </div>
                <!-- Main Content End -->

                @include("web.layouts.sidebar")

            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
<style>
    .el-empty {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        box-sizing: border-box;
        padding: 40px 0;
    }
    .el-empty__image {
        width: 160px;
    }
    .el-empty__description {
        margin-top: 20px;
    }
</style>
