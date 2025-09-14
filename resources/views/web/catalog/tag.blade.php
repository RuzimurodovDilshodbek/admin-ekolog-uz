@extends("web.layouts.app")


@php

    $breadCrumbs = [
        [
            "label"=> $tag->title
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
                    <h3 class="list-title"><b>{{ $tag->title}}</b></h3>

                    <div class="sticky-content-inner">
                        @php
                            $chunkedPosts = $posts->chunk(4); // Chunk the posts into groups of 4
                        @endphp

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

                    </div>
                </div>
                <!-- Main Content End -->

                @include("web.layouts.sidebar")

            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
