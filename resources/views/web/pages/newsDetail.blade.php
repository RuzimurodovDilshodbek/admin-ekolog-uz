@extends("web.layouts.app")

@section('title', $post->title)
@section('meta_description', $post->description ?? $post->title)
@section('meta_keywords', implode(',', $post->tags?->pluck('title')?->toArray()))
@section('og_type', 'article')
@section('og_image', $post->detail_image?->show_card)


@php

    $breadCrumbs = [
        [
            "label"=>$post->section?->title,
            "url"=>$post->section?->url
        ],
                [
            "label"=>$post->title,
        ],
    ];

@endphp


@section("content")

    <!-- Main Breadcrumb Start -->
    @include("web.layouts.breadcrumb",[
        "breadcrumbs"=>$breadCrumbs
    ])
    <main>
        <div class="container main__wrapper d-md-flex justify-content-md-between darkMode">
            <section class="single">
                <h2 class="single__title">Maktab o'quvchilari ilk bor Prezident Administratsiyasiga bordi</h2>
                <div class="single__info darkMode">
                    <span class="darkMode">14 iyul, 2023 yil</span>
                    <div class="single__info-inner">
                        <img src="{{asset('images/eye_main.svg')}}" alt="eye icon">
                        <span class="darkMode">98</span>
                    </div>
                    <div class="single__info-inner">
                        <img src="{{asset('images/message.svg')}}" alt="message icon">
                        <span class="darkMode">98</span>
                    </div>
                    <div class="single__info-inner">
                        <img src="{{asset('images/share.svg')}}" alt="share icon">
                        <span class="darkMode">98</span>
                    </div>
                </div>
                <img src="{{asset('images/main_img.jpg')}}" alt="main image" class="single__mainImg">
                <div class="single__inner ">
                    <ul class="single__social d-none d-sm-flex list-unstyled ">
                        <li class="darkMode-btn"><img src="./images/insta.svg" alt="instagram icon"></li>
                        <li class="darkMode-btn"><img src="./images/telegram1.svg" alt="telegram icon"></li>
                        <li class="darkMode-btn"><img src="./images/share.svg" alt="share icon"></li>
                    </ul>
                    <div class="single__main">
                        <div class="single__main-inner d-flex ">
                            <ul class="single__social list-unstyled d-flex d-sm-none ">
                                <li class="darkMode-btn"><img src="./images/insta.svg" alt="instagram icon"></li>
                                <li class="darkMode-btn"><img src="./images/telegram1.svg" alt="telegram icon"></li>
                                <li class="darkMode-btn"><img src="./images/share.svg" alt="share icon"></li>
                            </ul>
                            <div class="single__text-wrapper">
                                <p class="single__text">22 dekabr kuni tanlov va fan olimpiadalarida g‘alaba qozongan
                                    maktab
                                    o‘quvchilari Prezident
                                    Administratsiyasiga bordi.
                                    Bu haqda O‘zbekiston Respublikasi Prezidenti Shavkat Mirziyoyevning to‘ng‘ich qizi –
                                    Prezident yordamchisi Saida
                                    Mirziyoyeva o‘zining ijtimoiy tarmoqdagi sahifasida ma’lum qildi.
                                </p>
                                <p class="single__text">
                                    Uning aytishicha, g‘olib jamoalar pul mukofotlariga ega bo‘lgan va 70 nafar finalchi
                                    14
                                    nafar o‘qituvchi hamrohligida
                                    Buyuk Britaniyada bo‘lib, u yerda bir hafta mobaynida nufuzli ingliz maktablarining
                                    o‘quvchilari sifatida dars va
                                    mashg‘ulotlarda qatnashganUning aytishicha, g‘olib jamoalar pul mukofotlariga ega
                                    bo‘lgan va
                                    70 nafar finalchi 14 nafar
                                    o‘qituvchi hamrohligida
                                </p>
                                <p class="single__text">
                                    Buyuk Britaniyada bo‘lib, u yerda bir hafta mobaynida nufuzli ingliz maktablarining
                                    o‘quvchilari sifatida dars va
                                    mashg‘ulotlarda qatnashgan. Shuningdek, ular London, Oksford va Kembrij shaharlari
                                    bilan
                                    ham
                                    tanishgan. O‘qituvchilar
                                    esa ingliz tilini o‘qitishning ilg‘or metodikalarini o‘rganish imkoniyatiga ega
                                    bo‘lga.
                                    Shuningdek, ular London, Oksford
                                    va Kembrij shaharlari bilan ham tanishgan. O‘qituvchilar esa ingliz tilini
                                    o‘qitishning
                                    ilg‘or metodikalarini o‘rganish
                                    imkoniyatiga ega bo‘lgan.
                                </p>
                            </div>
                        </div>
                        <div class="single__qs darkMode-body">
                            <img src="./images/dod.svg" alt="dod icon">
                            <p class="single__qs-text">Shuningdek, Prezident yordamchisi ta’lim islohoti doirasida
                                “Xorijiy tillarni o‘qitish
                                bo‘yicha eng yaxshi maktab”
                                tanlovi o‘tkazilganini, unda 6885 ta maktab va 7–9-sinflarning 35 mingga yaqin
                                o‘quvchilari ishtirok etganini qayd
                                etgan.</p>
                        </div>

                        <!-- <div class="single__card card border-0 shadow-0">
                            <img src="./images/Ellipse.svg" alt="Ellipse iimage" class="card__img-main">
                            <div class="card__wrapper">
                                <div class="card__wrapper-inner">
                                    <img src="./images/chanelRasmiy.png" alt="chanelRasmiy image">
                                    <img src="./images/rectangle.jpg" alt="rectangle image" class="card__img-big">
                                </div>
                            </div>
                        </div> -->
                        <p class="single__text">22 dekabr kuni tanlov va fan olimpiadalarida g‘alaba qozongan maktab
                            o‘quvchilari Prezident
                            Administratsiyasiga bordi.
                            Bu haqda O‘zbekiston Respublikasi Prezidenti Shavkat Mirziyoyevning to‘ng‘ich qizi –
                            Prezident yordamchisi Saida
                            Mirziyoyeva o‘zining ijtimoiy tarmoqdagi sahifasida ma’lum qildi.</p>
                        <p class="single__text">Men ularga mamnuniyat bilan Administratsiya ish faoliyati haqida
                            tushuncha berib, ekskursiya
                            uyushtirdim. Bolalar aqlli
                            va qiziquvchan. Ko‘ngli ochiq va to‘g‘riso‘z. Ular bizning kelajagimiz, deydi Mirziyoyeva.
                        </p>
                        <p class="single__text">Shuningdek, Prezident yordamchisi ta’lim islohoti doirasida “Xorijiy
                            tillarni o‘qitish
                            bo‘yicha eng yaxshi maktab”
                            tanlovi o‘tkazilganini, unda 6885 ta maktab va 7–9-sinflarning 35 mingga yaqin o‘quvchilari
                            ishtirok etganini qayd
                            etgan.</p>
                        <p class="single__text">Uning aytishicha, g‘olib jamoalar pul mukofotlariga ega bo‘lgan va 70
                            nafar finalchi 14 nafar
                            o‘qituvchi hamrohligida
                            Buyuk Britaniyada bo‘lib, u yerda bir hafta mobaynida nufuzli ingliz maktablarining
                            o‘quvchilari sifatida dars va
                            mashg‘ulotlarda qatnashgan. .
                            Uning aytishicha, g‘olib jamoalar pul mukofotlariga ega bo‘lgan va 70 nafar finalchi 14
                            nafar o‘qituvchi hamrohligida
                            Buyuk Britaniyada</p>
                        <p class="single__text">Uning aytishicha, g‘olib jamoalar pul mukofotlariga ega bo‘lgan va 70
                            nafar finalchi 14 nafar
                            o‘qituvchi hamrohligida
                            Buyuk Britaniyada bo‘lib, u yerda bir hafta mobaynida nufuzli ingliz maktablarining
                            o‘quvchilari sifatida dars va
                            mashg‘ulotlarda qatnashgan. bo‘lib, u yerda bir hafta mobaynida nufuzli ingliz
                            maktablarining o‘quvchilari sifatida dars
                            va mashg‘ulotlarda qatnashgan.</p>

                        <div class="single__tags d-none d-md-block">
                            <h4 class="single__tags-title">Teglar</h4>
                            <ul class="list-unstyled">
                                <li>Maktablar</li>
                                <li>Bolalar</li>
                                <li>O'quvchi</li>
                                <li>Maktab</li>
                                <li>Sahovat</li>
                                <li>O'zbekiston</li>
                            </ul>
                        </div>
                        <div class="single__auther auther d-none d-md-flex">
                            <div class="single__auther-name">
                                <p class="single__auther-text">Maqola muallifi</p>
                                <div class="single__auther-inner">
                                    <img src="./images/person.png" alt="person image">
                                    <h4 class="single__auther-title">Firdavs Muzafarov</h4>
                                </div>
                            </div>
                            <div class="single__auther-name">
                                <p class="single__auther-text">Maqolaga baho bering</p>
                                <div class="rating"> <input type="radio" name="rating" value="5" id="5"><label
                                        for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label
                                        for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label
                                        for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label
                                        for="2">☆</label>
                                    <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                </div>
                            </div>
                            <div class="single__auther-name">
                                <p class="single__auther-text">Ulashish</p>
                                <ul class="single__auther-share list-unstyled ">
                                    <li class="darkMode-btn"><img src="./images/telegram1.svg" alt="telegram icon"></li>
                                    <li class="darkMode-btn"><img src="./images/insta.svg" alt="instagram icon"></li>
                                    <li class="darkMode-btn"><img src="./images/share.svg" alt="share icon"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single__message none-container">
                            <div class="single__message-top">
                                <div class="single__message-2btn d-flex align-items-center justify-content-between">
                                    <img src="./images/person.png" alt="person image">
                                    <button class="d-block d-sm-none btn btn-light border-0 shadow-0"
                                            data-mdb-ripple-init data-mdb-ripple-color="dark">Yuborish</button>
                                </div>
                                <textarea name="" id="" cols="30" rows="10" placeholder="Fikr qo‘shish…"></textarea>
                                <button class="d-none d-sm-block btn btn-light border-0 shadow-0" data-mdb-ripple-init
                                        data-mdb-ripple-color="dark">Yuborish</button>
                            </div>
                            <ul class="single__message-list list-unstyled">
                                <li class="single__message-item item">
                                    <div class="item__inner">
                                        <div class="item__left">
                                            <img src="./images/person.png" alt="person image">
                                            <h4>Bahrom</h4>
                                        </div>
                                        <!-- <div class="item__right">
                                            <img src="" alt="">
                                            <img src="" alt="">
                                        </div> -->
                                    </div>
                                    <p class="item__text">@maxblagun Agar siz hali ham yangi bo'lsangiz, React-ni ko'rib
                                        chiqishdan oldin
                                        HTML, CSS va JS asoslariga e'tibor
                                        qaratishni maslahat beraman. Oldinga sakrash juda jozibali, lekin avvalo
                                        mustahkam poydevor qo'ying.</p>
                                </li>
                                <li class="single__message-item item">
                                    <div class="item__inner">
                                        <div class="item__left">
                                            <img src="./images/person.png" alt="person image">
                                            <h4>Bahrom</h4>
                                        </div>
                                        <!-- <div class="item__right">
                                            <img src="" alt="">
                                            <img src="" alt="">
                                        </div> -->
                                    </div>
                                    <p class="item__text">@maxblagun Agar siz hali ham yangi bo'lsangiz, React-ni ko'rib
                                        chiqishdan oldin
                                        HTML, CSS va JS asoslariga e'tibor
                                        qaratishni maslahat beraman. Oldinga sakrash juda jozibali, lekin avvalo
                                        mustahkam poydevor qo'ying.</p>
                                </li>
                                <li class="single__message-item item">
                                    <div class="item__inner">
                                        <div class="item__left">
                                            <img src="./images/person.png" alt=" person image">
                                            <h4>Bahrom</h4>
                                        </div>
                                        <div class="item__right">
                                            <img src="./images/shape.svg" alt="delete icon">
                                            <img src="./images/rename.svg" alt="rename icon">
                                        </div>
                                    </div>
                                    <p class="item__text">@maxblagun Agar siz hali ham yangi bo'lsangiz, React-ni ko'rib
                                        chiqishdan oldin
                                        HTML, CSS va JS asoslariga e'tibor
                                        qaratishni maslahat beraman. Oldinga sakrash juda jozibali, lekin avvalo
                                        mustahkam poydevor qo'ying.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <aside>
                <section class="aside">
                    <h4 class="aside__title">Ko'p o'qilganlar</h4>
                    <div class="aside__wrapper">
                        <div class="lastNews__left-inner card h-100 shadow-0 rounded-0 darkMode">
                            <div class="position-relative">
                                <img src="images/lastNew1.jpg" class="card-img-top rounded-0"
                                     alt="Hollywood Sign on The Hill" />
                                <span class="position-absolute lastNews__left-spLink darkMode">Salomatlik</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title darkMode">Mirziyoyeva oilasi bolalar kutubga bordi.
                                </h5>
                                <p class="card-text darkMode">
                                    Prezident yordamchisi Saida Mirziyoyeva farzandlari bilan bolalar
                                    kutubxonasiga keldi.....
                                </p>
                                <span class="lastNews__left-sp darkMode-sp">12.12.2023 12:32</span>
                            </div>
                        </div>
                        <img src="./images/add_img.jpg" alt="add image" class="aside__img-add">
                        <div class="lastNews__left-inner card h-100 shadow-0 rounded-0 darkMode">
                            <div class="position-relative">
                                <img src="images/lastNew1.jpg" class="card-img-top rounded-0"
                                     alt="Hollywood Sign on The Hill" />
                                <span class="position-absolute lastNews__left-spLink darkMode">Salomatlik</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title darkMode">Mirziyoyeva oilasi bolalar kutubga bordi.
                                </h5>
                                <p class="card-text darkMode">
                                    Prezident yordamchisi Saida Mirziyoyeva farzandlari bilan bolalar
                                    kutubxonasiga keldi.....
                                </p>
                                <span class="lastNews__left-sp darkMode-sp">12.12.2023 12:32</span>
                            </div>
                        </div>
                        <img src="./images/add_img.jpg" alt="add image" class="aside__img-add">
                        <div class="lastNews__left-inner card h-100 shadow-0 rounded-0 darkMode">
                            <div class="position-relative">
                                <img src="images/lastNew1.jpg" class="card-img-top rounded-0"
                                     alt="Hollywood Sign on The Hill" />
                                <span class="position-absolute lastNews__left-spLink darkMode">Salomatlik</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title darkMode">Mirziyoyeva oilasi bolalar kutubga bordi.
                                </h5>
                                <p class="card-text darkMode">
                                    Prezident yordamchisi Saida Mirziyoyeva farzandlari bilan bolalar
                                    kutubxonasiga keldi.....
                                </p>
                                <span class="lastNews__left-sp darkMode-sp">12.12.2023 12:32</span>
                            </div>
                        </div>
                    </div>
                </section>
            </aside>
        </div>

        <section class="slide-option loopScroler bg-white darkMode d-none d-md-flex">
            <div id="infinite" class="highway-slider">
                <div class="highway-barrier">
                    <ul class="highway-lane list-unstyled m-0 darkMode">
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                        <li class="highway-car"><img src="./images/dunyoBola-img.svg" alt="dunyoBola-img"
                                                     class="lightIcon d-block img-fluid" />
                            <img src="./images/dunyoBola-img-dark1.jpg" alt="dunyoBola-img"
                                 class="darkIcon d-none darkMode img-fluid" style="width: 204px;" />
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

@endsection
