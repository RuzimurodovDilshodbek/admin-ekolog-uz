<header class="header fixed-top darkMode">
    <div class="header__wrapper ">
        <!-- header top navbar -->
        <div class="container header__top d-flex justify-content-between align-items-center">
            <div class="header__top-left ">
                <span class="header__info-text">Тошкент шаҳри</span>
                <a class="link-opacity-75-hover" href="#">info@bolalarolami</a>
            </div>
            <div class="header__top-right d-flex align-items-center">
                <div class="header__top-texts d-none d-md-flex  ">
                    <span class="darkMode">{{ __('home.Гувоҳнома рақами') }}: №073429</span>
                    <span class="darkMode">Masʼul muharrir: Sherali Soliyev</span>
                </div>
                <div class="header__top-menuList d-flex align-items-center" style="gap: 16px;">
                    <img src="{{asset('images/glasses.svg')}}" alt="glasses icon" class="lightIcon d-block " />
                    <img src="{{asset('images/glasses_d.svg')}}" alt="glasses icon" class="darkIcon d-none " />
                    <div id="themingSwitcher">
                        <img src="{{asset('images/moon.svg')}}" alt="moon icon" class="lightIcon d-block cur" />
                        <img src="{{asset('images/moon_d.svg')}}" alt="moon icon" class="darkIcon d-none " />
                    </div>
                    <button type="button" class="header__top-mainBtn btn d-xl-none shadow-0 darkMode-btn"
                            data-mdb-ripple-init>Kirish</button>
{{--                    <select class="header__top-btn darkMode-btn d-xl-none" aria-label="Default select example">--}}
{{--                        @foreach (config('app.locales') as $locale)--}}
{{--                            <option value="{{ $locale }}">--}}
{{--                                <a href="{{ route('changeLang', ['to_locale' => $locale, 'from_route' => \Illuminate\Support\Facades\Route::current()->getName(), 'params' => json_encode(\Illuminate\Support\Facades\Route::current()->parameters()) ])  }}" style="text-transform: uppercase; color:#000;">--}}
{{--                                    {{ $locale == 'kr' ? 'ЎЗ' : ($locale == 'uz' ? 'ŌZ'  : ($locale == 'uz' ? 'ŌZ' : $locale))   }}--}}
{{--                                </a>--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
                    <div class="header__top-btn darkMode-btn d-xl-none" aria-label="Default select example">
                        <details>
                            <summary>{{ \Illuminate\Support\Facades\Route::current()->getPrefix()  }}</summary>
                            <ul class="header__top-btn mt-4  darkMode-btn d-xl-none list-unstyled m-0" style="gap: 10px;" aria-label="Language select">
                                @foreach (config('app.locales') as $locale)
                                    <li class="header__top-item darkMode">
                                        <a href="{{ route('changeLang', ['to_locale' => $locale, 'from_route' => \Illuminate\Support\Facades\Route::current()->getName(), 'params' => json_encode(\Illuminate\Support\Facades\Route::current()->parameters()) ])  }}" style="text-transform: uppercase; color:#000;">{{ $locale == 'kr' ? 'ЎЗ' : ($locale == 'uz' ? 'ŌZ'  : ($locale == 'uz' ? 'ŌZ' : $locale))   }}</a></li>
                                @endforeach
                            </ul>
                        </details>

                    </div>
                    <ul class="header__top-list d-none d-xl-flex align-items-center list-unstyled m-0" style="gap: 10px;">
                        @foreach (config('app.locales') as $locale)
                            <li class="header__top-item darkMode">
                                <a href="{{ route('changeLang', ['to_locale' => $locale, 'from_route' => \Illuminate\Support\Facades\Route::current()->getName(), 'params' => json_encode(\Illuminate\Support\Facades\Route::current()->parameters()) ])  }}" style="text-transform: uppercase; color:#000;">{{ $locale == 'kr' ? 'ЎЗ' : ($locale == 'uz' ? 'ŌZ'  : ($locale == 'uz' ? 'ŌZ' : $locale))   }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


        <!-- header bottom navbar -->
        <nav class="header__navbar navbar navbar-expand-xl navbar-light shadow-0 darkMode">
            <div class="container  darkMode">
                <!-- brand -->
                <a class="navbar-brand m-0" href="#">
                    <img src="{{asset('images/logo.svg')}}" class="lightIcon d-block" height="29" alt="bolalar olami Logo"
                         loading="lazy" />
                    <img src="{{asset('images/logo_d.svg')}}" class="darkIcon d-none" height="29" alt="bolalar olami Logo"
                         loading="lazy" />
                </a>

                <!-- middle -->
                <div class="darkMode navbar-collapse header__navbar-middle collapse" id="navbarTogglerDemo02">
                @php
                    $sections  = \App\Models\Section::query()->doesntHave("parent")->where("status",1)->orderBy("sort")->get();
                @endphp

                    <!-- navbar list -->
                    <ul class="darkMode navbar-nav d-none d-xl-flex justify-content-center w-100">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Bosh sahifa</a>
                        </li>
                        @foreach($sections as $section)
                            @if($section->childs()->exists())
                                <li class="nav-item position-relative darkMode">
                                    <a class="nav-link" href="{{$section->detailurl }}">{{ $section->title }}</a>
                                    <div class="darkMode d-none item-menu list-group list-group-light position-absolute">
                                        @foreach($section->childs as $childSection)
                                            <button type="button" class="list-group-item list-group-item-action  border-0 ">
                                                <a href="{{$childSection->detailurl}}">{{ $childSection->title }}</a>
                                            </button>
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{$section->detailurl}}">{{ $section->title }}</a>
                                </li>
                            @endif

                        @endforeach
                    </ul>

                    <!-- accordion -->
                    <div class="darkMode accordion container my-3 d-flex flex-column d-xl-none left-0 "
                         style="gap: 12px;" id="accordionExample">
                        @foreach($sections as $section)
                            @if($section->childs()->exists())
                                <div class="accordion-item darkMode-btn">
                                    <h2 class="accordion-header" id="1">
                                            <button data-mdb-collapse-init class="darkMode rounded-3 accordion-button shadow-0 "
                                                    type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne1"
                                                    aria-expanded="true" aria-controls="collapseOne1">
{{--                                                <a href="{{$section->detailurl}}">--}}
                                                    {{ $section->title }}
{{--                                                </a>--}}
                                            </button>

                                    </h2>
                                    <div id="collapseOne1" class="accordion-collapse collapse border-0" aria-labelledby="1"
                                         data-mdb-parent="#accordionExample">
                                        <ul class="accordion-body list-unstyled">
                                            @foreach($section->childs as $childSection)
                                                <li><a href="{{$childSection->detailurl}}">{{ $childSection->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="accordion-item darkMode-btn">
                                    <h2 class="accordion-header" id="1">
                                        <button data-mdb-collapse-init class="darkMode btn rounded-3 mobile-button shadow-0 "
                                                type="button" data-mdb-toggle="collapse"
                                                aria-expanded="true" aria-controls="collapseOne">
                                            {{ $section->title }}
                                        </button>
                                    </h2>
                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>

                <!-- right -->
                <div class="header__navbar-right d-flex align-items-center darkMode">
                    <button type="button" class="darkMode-btn btn shadow-0 header__navbar-btn" data-mdb-ripple-init>
                        <img src="{{asset('images/search.svg')}}" class="lightIcon d-block" alt="search icon">
                        <img src="{{asset('images/search_d.svg')}}" class="darkIcon d-none" alt="search icon">
                    </button>
                    <button data-mdb-collapse-init
                            class="darkMode-btn navbar-toggler header__navbar-btn d-xl-none collapsed" type="button"
                            data-mdb-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <img src="{{asset('images/x.svg')}}" alt="x icon" class="">
                        <img src="{{asset('images/menu.svg')}}" alt="menu icon" class="d-none">
                    </button>
                    <!-- Avatar -->
                    <div class="dropdown">
                        <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow"
                           href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                            <img src="{{asset('images/person.png')}}" class="rounded-circle" height="35" alt="person"
                                 loading="lazy" />
                        </a>

                        <!-- width uzi 182px  -->
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 192px;"
                            aria-labelledby="navbarDropdownMenuAvatar">
                            <li class="d-flex align-items-start" style="gap: 8px; padding: 10px 10px 4px 10px;">
                                <img src="{{asset('images/person.png')}}" class="rounded-circle" height="35" alt="person"
                                     loading="lazy" />

                                <div>
                                    <h4 class="m-0" style="font-size: 14px;  line-height: 20px;">Firdavs Muzaffarov
                                    </h4>
                                    <span style="color: rgba(36, 36, 36, 0.50); font-size: 11px; line-height: 20px;"
                                          class="darkMode-sp">info@gmail.com</span>
                                </div>
                            </li>
                            <li>
                            <li>
                                <a class="dropdown-item" href="#">Akaunt sozlamalari</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Qorong'i rejim</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Yordam</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Chiqish</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<style>
    .header__navbar .navbar-nav{
        gap: 14px;
    }
    .list-group-item-action a{
        color: #000000;
    }
    .list-group-item-action a:hover{
        color: #0012fb;
    }
    .mobile-button {
        background: #F6F6F6;
        padding: 20px 10px;
        color: #242424;
        font-size: 15px;
        font-weight: 500;
        text-transform: capitalize;
    }
    .accordion-body {
     color: #000000;
    }
</style>
