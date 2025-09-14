<?php


use App\Models\TutorOpinion;

$tags = \App\Models\Tag::query()
    ->where("status", 1)
    ->limit(15)
    ->get();


$ads = \App\Models\Ad::query()
    ->where("position", "right")
    ->where("status", 1)
    ->orderBy("sort")
    ->get();

$trendPosts = \App\Models\Post::query()
    ->where("type", "trend")
    ->where("status", 1)
    ->orderBy("created_at", "DESC")
    ->limit(6)
    ->inRandomOrder()
    ->get();

$mostViewedPosts = \App\Models\Post::getMostViewedPosts(5);
$recommendedPosts = \App\Models\Post::getRecommendedPosts(5);
$opinions = TutorOpinion::query()
    ->limit(10)
//    ->orderBy("created_at", "DESC")
    ->orderBy("sort")
    ->inRandomOrder()
    ->get();
?>





    <!-- Main Sidebar Start -->
<div class="main--sidebar col-md-4 col-sm-5 pbottom--30" data-sticky-content="true">
    <div class="sticky-content-inner">

        @php
            $polls = \App\Models\Poll::query()->where("status", 1)->get();
        @endphp


            <!-- Widget Start -->
        <div class="widget">
            <div class="widget--title">
                <h2 class="h4">{{__("home.Энг кўп ўқилган")}}</h2>
                {{--                <i class="icon fa fa-newspaper-o"></i>--}}
            </div>

            <!-- List Widgets Start -->
            <div id="list-widget" class="list--widget list--widget-1">
                <!-- Post Items Start -->
                <div class="post--items post--items-3">
                    <ul id="innerListHtml" class="nav">
                        @include("web.pages.post.hot-list",["posts"=>$mostViewedPosts])
                    </ul>
                </div>
                <!-- Post Items End -->
            </div>
            <!-- List Widgets End -->
        </div>
        <!-- Widget End -->

        <!-- Widget Start -->
        <div class="widget">
            <div class="widget--title">
                <h2 class="h4">{{ __('home.Тавсия қилинган')}}</h2>
                {{--                <i class="icon fa fa-newspaper-o"></i>--}}
            </div>

            <!-- List Widgets Start -->
            <div class="list--widget list--widget-1">
                <!-- Post Items Start -->
                <div class="post--items post--items-3">
                    <ul id="innerListHtml" class="nav">
                        @include("web.pages.post.hot-list",["posts"=>$recommendedPosts])
                    </ul>
                </div>
                <!-- Post Items End -->
            </div>
            <!-- List Widgets End -->
        </div>
        <!-- Widget End -->


        @foreach($polls as $poll)
            <!-- Widget Start -->
            <div class="widget">
                <div class="widget--title" data-ajax="tab">
                    <h2 class="h4">{{__('home.Сўровнома')}}</h2>
                </div>
                <!-- Poll Widget Start -->
                <div class="poll--widget list--widget" data-ajax-content="outer">

                    @include('web.pages.poll.answered',["poll"=>$poll])
                    <!-- Preloader Start -->
                    <div class="preloader bg--color-0--b" data-preloader="1">
                        <div class="preloader--inner"></div>
                    </div>
                    <!-- Preloader End -->
                </div>
                <!-- Poll Widget End -->
            </div>
            <!-- Widget End -->

        @endforeach

        @if(count($opinions) > 0)
        <!-- Widget Start -->
            <div class="widget">
                <div class="widget--title" data-ajax="tab">
                    <h2 class="h4">{{__("home.Фикрлар")}}</h2>
                </div>
                <div class="opinions list--widget p-2" style="padding: 10px">
                    <div class="card-opinion-collection__list">
                        @foreach($opinions as $opinion)
                            @if($opinion->post->tutor?->firstname)
                                <div>
                                    <article class="card-opinion-collection__article u-clickable-card">
                                        <img alt="Rami G Khouri" class="card-opinion-collection__article__avatar" src="{{$opinion->image?->url}}" loading="lazy" aria-hidden="true">
                                        <div class="card-opinion-collection__article__content">
                                            <a class="card-opinion-collection__article__link u-clickable-card__link" href="{{$opinion->post->detailUrl}}">
                                                <div class="card-opinion-collection__article__title">
                                                    <span>{{$opinion->short_title}}</span>
                                                </div>
                                                <div class="card-opinion-collection__article__meta">
                                                    <svg class="icon icon--quotes icon--primary icon--16 card-opinion-collection__article__icon" viewBox="0 0 20 20" version="1.1" aria-hidden="true">
                                                        <title>quotes</title>
                                                        <path class="icon-main-color" d="M8.75 13.94a3.32 3.32 0 0 1-1.12 2.49A3.74 3.74 0 0 1 5 17.5a4.43 4.43 0 0 1-3.69-1.62A7.09 7.09 0 0 1 0 11.38 8.6 8.6 0 0 1 2.21 6a14.43 14.43 0 0 1 5.34-4.12l1 1.58a12.06 12.06 0 0 0-3.9 2.84A6.94 6.94 0 0 0 3 10.24h1.25a6.46 6.46 0 0 1 2.21.32 3.38 3.38 0 0 1 1.37.86 3.08 3.08 0 0 1 .71 1.18 4.32 4.32 0 0 1 .21 1.34zm11.25 0a3.32 3.32 0 0 1-1.12 2.49 3.74 3.74 0 0 1-2.65 1.07 4.43 4.43 0 0 1-3.69-1.62 7.09 7.09 0 0 1-1.29-4.5A8.6 8.6 0 0 1 13.46 6a14.43 14.43 0 0 1 5.34-4.12l1 1.58a12.06 12.06 0 0 0-3.9 2.84 6.94 6.94 0 0 0-1.62 3.94h1.22a6.46 6.46 0 0 1 2.21.32 3.38 3.38 0 0 1 1.37.86 3.08 3.08 0 0 1 .71 1.18 4.32 4.32 0 0 1 .21 1.34z"></path>
                                                    </svg>
    {{--                                                {{ $opinion->post->tutor }}--}}
                                                    <span class="screen-reader-text">{{$opinion->post->tutor->firstname}} {{$opinion->post->tutor->lastname}}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endif
                        @endforeach
                </div>
            </div>
            <!-- Widget End -->


{{--        <!-- Widget Start -->--}}
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">Tavsiya etilgan</h2>--}}
{{--                <i class="icon fa fa-newspaper-o"></i>--}}
{{--            </div>--}}

{{--            <!-- List Widgets Start -->--}}
{{--            <div class="list--widget list--widget-1">--}}
{{--                <div class="list--widget-nav" data-ajax="tab">--}}
{{--                    <ul class="nav nav-justified">--}}
{{--                        <li>--}}
{{--                            <a href="{{url("api/news/list-action-items")}}"--}}
{{--                               data-ajax-action="load_widget_hot_news">{{__("Qaynoq")}}</a>--}}
{{--                        </li>--}}
{{--                        <li class="active">--}}
{{--                            <a href="{{url("api/news/list-action-items")}}"--}}
{{--                               data-ajax-action="load_widget_trendy_news">{{__("Trend")}}</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="{{url("api/news/list-action-items")}}"--}}
{{--                               data-ajax-action="load_widget_most_watched">{{__("Ko'p ko'rilgan")}}</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--                <!-- Post Items Start -->--}}
{{--                <div class="post--items post--items-3" data-ajax-content="outer">--}}
{{--                    <ul id="innerListHtml" class="nav" data-ajax-content="inner">--}}
{{--                        @include("web.pages.post.hot-list",["posts"=>$trendPosts])--}}
{{--                    </ul>--}}

{{--                    <!-- Preloader Start -->--}}
{{--                    <div class="preloader bg--color-0--b" data-preloader="1">--}}
{{--                        <div class="preloader--inner"></div>--}}
{{--                    </div>--}}
{{--                    <!-- Preloader End -->--}}
{{--                </div>--}}
{{--                <!-- Post Items End -->--}}
{{--            </div>--}}
{{--            <!-- List Widgets End -->--}}
{{--        </div>--}}
{{--        <!-- Widget End -->--}}

        @if(isset($ads[0]))
            <!-- Widget Start -->
            <div class="widget">
                <div class="widget--title">
                    <h2 class="h4">{{__("home.Реклама")}}</h2>
                </div>

                <!-- Ad Widget Start -->
                <div class="ad--widget list--widget">
                    <a href="{{$ads[0]->url}}">
                        <img src="{{$ads[0]->image?->url}}" alt="">
                    </a>
                </div>
                <!-- Ad Widget End -->
            </div>
            <!-- Widget End -->
        @endif


        <!-- Widget Start -->
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">{{__("Kategoriyalar")}}</h2>--}}
{{--                <i class="icon fa fa-folder-open-o"></i>--}}
{{--            </div>--}}

        <!-- Widget Start -->
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">{{__("Teglar")}}</h2>--}}
{{--                <i class="icon fa fa-tags"></i>--}}
{{--            </div>--}}

{{--            <!-- Tags Widget Start -->--}}
{{--            <div class="tags--widget style--1">--}}
{{--                <ul class="nav">--}}
{{--                    @foreach($tags as $tag)--}}
{{--                        <li>--}}
{{--                            <a href="{{$tag->url}}">{{$tag->title}}</a>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}

{{--                </ul>--}}
{{--            </div>--}}
{{--            <!-- Tags Widget End -->--}}
{{--        </div>--}}
        <!-- Widget End -->

        <!-- Widget Start -->
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">{{__("Arxivlar")}}</h2>--}}
{{--                <i class="icon fa fa-folder-open-o"></i>--}}
{{--            </div>--}}

{{--            <!-- Nav Widget Start -->--}}
{{--            <div class="nav--widget">--}}
{{--                <ul class="nav">--}}

{{--                    @foreach(\App\Models\Post::archives() as $archive)--}}
{{--                        <li><a href="{{$archive['url']}}"><span>{{$archive['title']}}</span><span>({{$archive['post_count']}})</span></a>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <!-- Nav Widget End -->--}}
{{--        </div>--}}
        <!-- Widget End -->


        <!-- Widget Start -->
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">{{__("Doim biz bilan")}}</h2>--}}
{{--                <i class="icon fa fa-share-alt"></i>--}}
{{--            </div>--}}

{{--            <!-- Social Widget Start -->--}}
{{--            <div class="social--widget style--1">--}}
{{--                <ul class="nav">--}}
{{--                    <li class="facebook">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-facebook-f"></i></span>--}}
{{--                            <span class="count">521</span>--}}
{{--                            <span class="title">Likes</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="twitter">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-twitter"></i></span>--}}
{{--                            <span class="count">3297</span>--}}
{{--                            <span class="title">Followers</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="google-plus">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-google-plus"></i></span>--}}
{{--                            <span class="count">596282</span>--}}
{{--                            <span class="title">Followers</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="rss">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-rss"></i></span>--}}
{{--                            <span class="count">521</span>--}}
{{--                            <span class="title">Subscriber</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="vimeo">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-vimeo"></i></span>--}}
{{--                            <span class="count">3297</span>--}}
{{--                            <span class="title">Followers</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="youtube">--}}
{{--                        <a href="#">--}}
{{--                            <span class="icon"><i class="fa fa-youtube-square"></i></span>--}}
{{--                            <span class="count">596282</span>--}}
{{--                            <span class="title">Subscriber</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <!-- Social Widget End -->--}}
{{--        </div>--}}
        <!-- Widget End -->

        <!-- Widget Start -->
{{--        <div class="widget">--}}
{{--            <div class="widget--title">--}}
{{--                <h2 class="h4">{{__("Obuna bo'lish")}}</h2>--}}
{{--                <i class="icon fa fa-envelope-open-o"></i>--}}
{{--            </div>--}}

{{--            <!-- Subscribe Widget Start -->--}}
{{--            <div class="subscribe--widget">--}}
{{--                <div class="content">--}}
{{--                    <p>{{__("Bizning yangiliklardan doim habardor bo'lish uchun obuna bo'ling!")}}</p>--}}
{{--                </div>--}}

{{--                <form--}}
{{--                    action="{{url("api/newsletter")}}"--}}
{{--                    method="post" name="mc-embedded-subscribe-form" target="_blank"--}}
{{--                    data-form="mailchimpAjax">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="email" name="email" placeholder="E-mail address"--}}
{{--                               class="form-control" autocomplete="off" required>--}}

{{--                        <div class="input-group-btn">--}}
{{--                            <button type="submit" class="btn btn-lg btn-default active"><i--}}
{{--                                    class="fa fa-paper-plane-o"></i></button>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="status"></div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <!-- Subscribe Widget End -->--}}
{{--        </div>--}}
        <!-- Widget End -->


{{--        @if(isset($ads[1]))--}}
{{--            <!-- Widget Start -->--}}
{{--            <div class="widget">--}}
{{--                <div class="widget--title">--}}
{{--                    <h2 class="h4">{{__("Reklama")}}</h2>--}}
{{--                </div>--}}

{{--                <!-- Ad Widget Start -->--}}
{{--                <div class="ad--widget">--}}
{{--                    <a href="{{$ads[1]->url}}">--}}
{{--                        <img src="{{$ads[1]->image?->url}}" alt="">--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <!-- Ad Widget End -->--}}
{{--            </div>--}}
{{--            <!-- Widget End -->--}}
{{--        @endif--}}
    </div>
        @endif
    </div>
</div>
<!-- Main Sidebar End -->
<style>
    .card-opinion-collection__article__link.u-clickable-card__link {
        color: unset!important;
    }
</style>
