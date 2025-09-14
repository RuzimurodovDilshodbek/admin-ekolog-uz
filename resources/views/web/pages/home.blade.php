@extends("web.layouts.app")

@section('title', 'Bolalarolami.uz - Jahon va O‘zbekiston yangiliklari')
@section('meta_description', 'Bolalar olamiga oid barcha yangiliklar bizda ! Yangiliklar , salomatlik , huquqiy klinika , xayriya , adabiyot , foydaliga oid malumotlardan xabardor bo\'ling ')
@section('meta_keywords', 'Bolalar, Beg\'uborlik, Ota-ona, Nikoh, Yoshlar, Prezident, Oila, Farzand, Chaqaloq, Homiladorlik, Kelajak, O\'zgarish, Yangilik, O\'smir, UNICEF, Vazirlik, Tashrif')
@section('og_type', 'website')

@push("headStyles")

@endpush

@section("footerScripts")

@endsection

@section("content")
    <main>
        @include("web.pages.poll.heroHome")
        <section class="news">
            <div class="container">
                <h4 class="news__title darkMode-title">Asosiy</h4>
                <div class="news__wrapper">
                    <div class="news__left card bg-dark text-white news__cards  image-container w-100">
                        <img src="{{$mainPosts[0]->detail_image?->card}}" class="card-img img-fluid h-100 rounded-0 " alt="Stony Beach" />
                        <div class="card-img-overlay rounded-0 ">
                            <h5 class="news__card-title">{{$mainPosts[0]->title}}</h5>
                        </div>
                    </div>
                    <div class=" news__right">
                        @foreach($mainPosts as $id => $posts)
                            @if($id > 0)
                                <div class="card bg-dark text-white news__cards image-container w-100 ">
                                    <img src="{{$posts->detail_image?->card}}" class="card-img img-fluid h-100 rounded-0" alt="Stony Beach" />
                                    <div class="card-img-overlay rounded-0">
                                        <h5 class="news__card-title"><a style="color: #ffffff" href="{{$posts?->detailUrl}}">{{$posts->title}}</a></h5>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <section class="lastNews">
            <div class="container">
                <div class="lastNews__wrapper ">
{{--                    <div class="lastNews__left-wrap">--}}
{{--                        <h4 class="news__title darkMode-title">Ta'lim</h4>--}}
{{--                        <div class="lastNews__left">--}}
{{--                            @foreach($educationPosts as $id => $posts)--}}
{{--                            <div class="lastNews__left-inner card h-100 shadow-0 rounded-0 darkMode">--}}
{{--                                <div class="position-relative">--}}
{{--                                    <img src="{{$posts->detail_image?->card}}" class="card-img-top rounded-0"--}}
{{--                                         alt="Hollywood Sign on The Hill" />--}}
{{--                                    <span class="position-absolute lastNews__left-spLink darkMode">Ta'lim</span>--}}
{{--                                </div>--}}
{{--                                <div class="card-body d-flex flex-column">--}}
{{--                                    <h5 class="card-title darkMode"><a style="color: #000000" href="{{$posts?->detailUrl}}">{{$posts->title}}</a></h5>--}}
{{--                                    <p class="card-text darkMode">{{$posts->description}}</p>--}}
{{--                                    <span class="lastNews__left-sp darkMode-sp">12.12.2023 12:32</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="lastNews__left-wrap">
                        <h4 class="news__title darkMode-title">Ta'lim</h4>
                        <div class="lastNews__left">
                            @foreach($educationPosts as $id => $posts)
                            <div
                                class="lastNews__left-inner card h-100 border-0 shadow-0 rounded-0 darkMode"
                            >
                                <div
                                    class="position-relative lastNews__left-img"
                                >
                                    <img
                                        src="{{$posts->detail_image?->card}}"
                                        class="card-img-top rounded-0"
                                        alt="Hollywood Sign on The Hill"
                                    />
                                    <span class="position-absolute lastNews__left-spLink darkMode">Ta'lim</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title darkMode"><a style="color: #000000" href="{{$posts?->detailUrl}}">{{$posts->title}}</a></h5>
                                    <p class="card-text darkMode">{{$posts->description}}</p>
                                    <span class="lastNews__left-sp darkMode-sp">{{date('d.m.Y H:m',strtotime($posts->publish_date))}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lastNews__right darkMode border-0">
                        <h4 class="lastNews__right-title ">So'nggi yangiliklarga</h4>
                        <ul class="lastNews__right-list list-unstyled darkMode">
                            @foreach($recentNewsPosts as $id => $posts)
                            <li class="border-bottom">
                                <p class="lastNews__right-text darkMode"><a style="color: #000000" href="{{$posts?->detailUrl}}">{{$posts->title}}</a></p>
                                <div
                                    class=" lastNews__right-view d-flex justify-content-between align-items-center  darkMode-sp">
                                    <div class="d-flex align-items-center" style="gap: 7px;">
                                        <img src="{{asset('images/eye.svg')}}" alt="eye icon">
                                        <span class="lastNews__right-sp darkMode-sp">{{$posts->views_count}}</span>
                                    </div>
                                    <span
                                        class="lastNews__right-sp lastNews__right-spDate darkMode-sp">{{date('d.m.Y',strtotime($posts->publish_date))}}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="social">
            <div class="container">
                <h4 class="social__name-title darkMode-title">
                    Social questionnaire
                </h4>
                <div
                    id="carouselExampleInterval"
                    class="carousel slide"
                    data-bs-ride="carousel"
                >
                    <div class="carousel-inner social__qs-wrapper">
                        @foreach($quotations as $id => $quotation)
                        <div class="carousel-item active">
                            <img
                                src="{{$quotation->detail_image?->url}}"
                                alt="social image"
                                class="social__img"
                            />
                            <div class="social__qs">
                                <p class="social__qs-text post--content">{{ $quotation->title }}</p>
                                <h4 class="social__qs-title">{{ $quotation->author_name }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <section class="container">
            <div>
                <h4 class="media__title fw-bold darkMode-title">Media</h4>
                <div class="media__card">
                    <div class="position-relative media__card-img w-100 h-100">
                        <!-- <img class="img-fluid media__card--img w-100" src="/images/media-img1.png" alt="media-img1"> -->
                        <p
                            class="media__text position-absolute fw-bold fs-4 text-white"
                        >
                            Mirziyoyeva oilasi bolalar kutubxonasiga bordi.
                        </p>
                    </div>

                    <div class="position-relative media__card-img2 w-100 h-100">
                        <img
                            class="img-fluid w-100"
                            src="/images/media-img2.png"
                            alt="media-img2"
                        />
                        <p
                            class="media__text position-absolute fw-bold fs-4 text-white"
                        >
                            Mirziyoyeva oilasi bolalar kutubxonasiga bordi.
                        </p>
                    </div>

                    <div class="position-relative media__card-img3 w-100 h-100">
                        <img
                            class="img-fluid w-100"
                            src="/images/media-img3.png"
                            alt="media-img3"
                        />
                        <p
                            class="media__text position-absolute fw-bold fs-4 text-white"
                        >
                            Mirziyoyeva oilasi bolalar kutubxonasiga bordi.
                        </p>
                    </div>
                    <div class="position-relative media__card-img4 w-100 h-100">
                        <img
                            class="img-fluid w-100"
                            src="/images/media-img4.png"
                            alt="media-img4"
                        />
                        <p
                            class="media__text position-absolute fw-bold fs-4 text-white"
                        >
                            Mirziyoyeva oilasi bolalar kutubxonasiga bordi.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Achchiqtosh -->
        <section class="achchiqtosh">
            <div class="container">
                <div class="achchiqtosh__wrapper">
                    <div class="achchiqtosh__left d-flex flex-column">
                        <h4 class="achchiqtosh__title darkMode-title">
                            Achchiqtosh
                        </h4>
                        <div
                            id="carouselExampleInterval"
                            class="carousel slide"
                            data-bs-ride="carousel"
                        >
                            <div class="carousel-inner">
                                <div
                                    class="carousel-item position-relative image-container card border-0 rounded-0 bg-dark active"
                                    data-bs-interval="1000"
                                >
                                    <img
                                        src="/images/achchiqtosh-img1.png"
                                        class="card-img img-fluid h-100 rounded-0"
                                        alt="Stony Beach"
                                    />
                                    <div class="card-img-overlay rounded-0">
                                        <h5
                                            class="achchiqtosh__slider-text position-absolute"
                                        >
                                            Mirziyoyeva oilasi bolalar
                                            kutubxonasigaasdasdasd asd asd asd
                                            ada sdf sfsdfssdf sdf sdf sdfs fds
                                            fd sdasda sda bordi.
                                        </h5>
                                    </div>
                                </div>
                                <div
                                    class="carousel-item position-relative image-container card border-0 rounded-0 bg-dark"
                                    data-bs-interval="1000"
                                >
                                    <img
                                        src="/images/achchiqtosh-img1.png"
                                        class="card-img img-fluid h-100 rounded-0"
                                        alt="Stony Beach"
                                    />
                                    <div class="card-img-overlay rounded-0">
                                        <h5
                                            class="achchiqtosh__slider-text position-absolute"
                                        >
                                            Mirziyoyeva oilasi bolalar
                                            kutubxonasigaasdasdasd asd asd asd
                                            ada sdf sfsdfssdf sdf sdf sdfs fds
                                            fd sdasda sda bordi.
                                        </h5>
                                    </div>
                                </div>
                                <div
                                    class="carousel-item position-relative image-container card border-0 rounded-0 bg-dark"
                                    data-bs-interval="1000"
                                >
                                    <img
                                        src="/images/achchiqtosh-img1.png"
                                        class="card-img img-fluid h-100 rounded-0"
                                        alt="Stony Beach"
                                    />
                                    <div class="card-img-overlay rounded-0">
                                        <h5
                                            class="achchiqtosh__slider-text position-absolute"
                                        >
                                            Mirziyoyeva oilasi bolalar
                                            kutubxonasigaasdasdasd asd asd asd
                                            ada sdf sfsdfssdf sdf sdf sdfs fds
                                            fd sdasda sda bordi.
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="achchiqtosh__main-inner mt-3 mt-lg-5">
                            <h4 class="news__title darkMode-title">
                                Salomatlik
                            </h4>
                            <div class="achchiqtosh__card">
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="achchiqtosh__main-inner mt-3 mt-lg-5">
                            <h4 class="news__title darkMode-title">
                                Xususiy kilinika
                            </h4>
                            <div class="achchiqtosh__card">
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="achchiqtosh__main-inner mt-3 mt-lg-5">
                            <h4 class="news__title darkMode-title">Foydali</h4>
                            <div class="achchiqtosh__card">
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                                <div class="darkMode achchiqtosh__card-box">
                                    <div
                                        class="position-relative achchiqtosh__img-wrapper"
                                    >
                                        <img
                                            class="img-fluid w-100"
                                            src="/images/achchiqtosh-img2.png"
                                            alt="achchiqtosh-img2"
                                        />
                                        <span
                                            class="darkMode achchiqtosh__card-sp position-absolute"
                                        >
                                            SALOMATLIK
                                        </span>
                                    </div>
                                    <div class="achchiqtosh__info darkMode">
                                        <p
                                            class="darkMode-title achchiqtosh__info-title"
                                        >
                                            Mirziyoyeva oilasi bolalar kutubga
                                            bordi.
                                        </p>
                                        <p
                                            class="darkMode-title achchiqtosh__info-text"
                                        >
                                            Prezident yordamchisi Saida
                                            Mirziyoyeva farzandlari bilan
                                            bolalar kutubxonasiga keldi.....
                                        </p>
                                        <p
                                            class="darkMode-sp achchiqtosh__info-time"
                                        >
                                            12.12.2023 12:32
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-gap-3 d-none d-sm-flex flex-column">
                        <img
                            class="img-fluid achchiqtosh__card-box7"
                            src="/images/reklama-img.png"
                            alt="reklama-img"
                        />
                        <img
                            class="img-fluid achchiqtosh__card-box8"
                            src="/images/reklama-img1.png"
                            alt="reklama-img1"
                        />
                        <img
                            class="img-fluid achchiqtosh__card-box9"
                            src="/images/reklama-img1.png"
                            alt="reklama-img1"
                        />
                        <img
                            class="img-fluid achchiqtosh__card-box9"
                            src="/images/reklama-img1.png"
                            alt="reklama-img1"
                        />
                    </div>
                </div>
            </div>
        </section>
        <section class="slide-option loopScroler bg-white darkMode mb-0">
            <div id="infinite" class="highway-slider">
                <div class="highway-barrier">
                    <ul class="highway-lane list-unstyled m-0 darkMode">
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                        <li class="highway-car">
                            <img
                                src="/images/dunyoBola-img.svg"
                                alt="dunyoBola-img"
                                class="lightIcon d-block img-fluid"
                            />
                            <img
                                src="/images/dunyoBola-img-dark1.jpg"
                                alt="dunyoBola-img"
                                class="darkIcon d-none darkMode img-fluid"
                                style="width: 204px"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>
@endsection

