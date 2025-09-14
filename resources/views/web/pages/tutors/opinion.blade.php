@extends("web.layouts.app")



@section("content")

    <!-- Main Breadcrumb Start -->
    <div class="main--breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="/" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>
                <li><a href="/news" class="btn-link"><i class="fa fm fa-home"></i>News</a></li>
                <li class="active"><span>Soptio perferendis quas qui, repellat totam?</span></li>
            </ul>
        </div>
    </div>
    <!-- Main Breadcrumb End -->

    <!-- Main Content Section Start -->
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row">
                <!-- Main Content Start -->
                <div class="main--content col-md-8" data-sticky-content="true">
                    <div class="sticky-content-inner">
                        <!-- Post Item Start -->
                        <div class="post--item post--single post--title-largest pd--30-0">
                            <div class="post--img">
                                <a href="#" class="thumb"><img src="{{asset('img/news-single-img/post-img-01.jpg')}}"
                                                               alt=""></a>
                                <a href="#" class="icon"><i class="fa fa-star-o"></i></a>

                                <div class="post--map">
                                    <p class="btn-link"><i class="fa fa-map-o"></i>Location in Google Map</p>

                                    <div class="map--wrapper">
                                        <div data-map-latitude="23.790546" data-map-longitude="90.375583"
                                             data-map-zoom="6" data-map-marker="[[23.790546, 90.375583]]"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="post--cats">
                                <ul class="nav">
                                    <li><span><i class="fa fa-folder-open-o"></i></span></li>
                                    <li><a href="#">Fashion</a></li>
                                    <li><a href="#">Travel</a></li>
                                    <li><a href="#">Fitness</a></li>
                                    <li><a href="#">Music</a></li>
                                </ul>
                            </div>

                            <div class="post--info">
                                <ul class="nav meta">
                                    <li><a href="#">Norma R. Hogan</a></li>
                                    <li><a href="#">20 April 2017</a></li>
                                    <li><span><i class="fa fm fa-eye"></i>45k</span></li>
                                    <li><a href="#"><i class="fa fm fa-comments-o"></i>02</a></li>
                                </ul>

                                <div class="title">
                                    <h2 class="h4">It is a long established fact that a reader will be distracted by the
                                        readable content</h2>
                                </div>
                            </div>

                            <div class="post--content">
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour, or randomised words which
                                    don't look even slightly believable. If you are going to use a passage of Lorem
                                    Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of
                                    text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                                    chunks as necessary, making this the first true generator on the Internet. It uses a
                                    dictionary of over 200 Latin words, combined with a handful of model sentence
                                    structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem
                                    Ipsum is therefore always free from repetition words etc.</p>

                                <h4>Where does it come from?</h4>

                                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                                    piece of classical Latin literature from 45 BC, making it over 2000 years old.
                                    Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked
                                    up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and
                                    going through the cites of the word in classical literature, discovered the
                                    undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de
                                    Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45
                                    BC. This book is a treatise on the theory of ethics, very popular during the
                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes
                                    from a line in section 1.10.32.</p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="list">
                                            <li>Integer vitae libero ac risus egestas placerat.</li>
                                            <li>Fusce lobortis lorem at ipsum semper sagittis.</li>
                                            <li>Cras ornare tristique eros elit nulla nec ante.</li>
                                            <li>Ut aliquam sollicitudin iaculis ultricies nulla.</li>
                                            <li>Vivamus molestie gravida turpis lobortis lorem.</li>
                                            <li>Nam convallis pellentesque nisl commodo nulla.</li>
                                        </ul>
                                    </div>

                                    <div class="col-sm-6">
                                        <img src="{{asset('img/news-single-img/post-img-02.jpg')}}" alt="">
                                        <p class="img-caption">Finibus Bonorum et Malorum</p>
                                    </div>
                                </div>

                                <blockquote>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout. The point of using Lorem Ipsum is
                                        that it has a more-or-less normal making it look like readable english many
                                        desktop.</p>

                                    <footer>Semyaza, Australia</footer>
                                </blockquote>

                                <h4>Why do we use it?</h4>

                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content of a page when looking at its layout. The point of using Lorem Ipsum is that
                                    it has a more-or-less normal distribution of letters, as opposed to using 'Content
                                    here, content here', making it look like readable English. Many desktop publishing
                                    packages and web page editors now use Lorem Ipsum as their default model text, and a
                                    search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                                    versions have evolved over the years, sometimes by accident, sometimes on purpose
                                    (injected humour and the like).</p>
                            </div>
                        </div>
                        <!-- Post Item End -->

                        <!-- Advertisement Start -->
                        <div class="ad--space pd--20-0-40">
                            <a href="#">
                                <img src="{{asset('img/ads-img/ad-728x90-02.jpg')}}" alt="" class="center-block">
                            </a>
                        </div>
                        <!-- Advertisement End -->

                        <!-- Post Tags Start -->
                        <div class="post--tags">
                            <ul class="nav">
                                <li><span><i class="fa fa-tags"></i></span></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">News</a></li>
                                <li><a href="#">Image</a></li>
                                <li><a href="#">Music</a></li>
                                <li><a href="#">Video</a></li>
                                <li><a href="#">Audio</a></li>
                                <li><a href="#">Latest</a></li>
                                <li><a href="#">Trendy</a></li>
                                <li><a href="#">Special</a></li>
                                <li><a href="#">Recipe</a></li>
                            </ul>
                        </div>
                        <!-- Post Tags End -->

                        <!-- Post Social Start -->
                        <div class="post--social pbottom--30">
                            <span class="title"><i class="fa fa-share-alt"></i></span>

                            <!-- Social Widget Start -->
                            <div class="social--widget style--4">
                                <ul class="nav">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                </ul>
                            </div>
                            <!-- Social Widget End -->
                        </div>
                        <!-- Post Social End -->


                        <!-- Post Related Start -->
                        <div class="post--related ptop--30">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title" data-ajax="tab">
                                <h2 class="h4">You Might Also Like</h2>

                                <div class="nav">
                                    <a href="#" class="prev btn-link" data-ajax-action="load_prev_related_posts">
                                        <i class="fa fa-long-arrow-left"></i>
                                    </a>

                                    <span class="divider">/</span>

                                    <a href="#" class="next btn-link" data-ajax-action="load_next_related_posts">
                                        <i class="fa fa-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Post Items Title End -->

                            <!-- Post Items Start -->
                            <div class="post--items post--items-2" data-ajax-content="outer">
                                <ul class="nav row" data-ajax-content="inner">
                                    <li class="col-sm-6 pbottom--30">
                                        <!-- Post Item Start -->
                                        <div class="post--item post--layout-1">
                                            <div class="post--img">
                                                <a href="#" class="thumb"><img
                                                        src="{{asset('img/news-single-img/related-post-01.jpg')}}"
                                                        alt=""></a>
                                                <a href="#" class="cat">Fitness</a>
                                                <a href="#" class="icon"><i class="fa fa-flash"></i></a>

                                                <div class="post--info">
                                                    <ul class="nav meta">
                                                        <li><a href="#">Astaroth</a></li>
                                                        <li><a href="#">Yeasterday 03:52 pm</a></li>
                                                    </ul>

                                                    <div class="title">
                                                        <h3 class="h4"><a href="#" class="btn-link">On the other hand,
                                                                we denounce with righteous indignation and dislike
                                                                demoralized</a></h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="post--content">
                                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                                    blanditiis praesentium voluptatum deleniti atque corrupti quos
                                                    mollitia animi, id est laborum et dolorum fuga.</p>
                                            </div>

                                            <div class="post--action">
                                                <a href="#">Continue Reading... </a>
                                            </div>
                                        </div>
                                        <!-- Post Item End -->
                                    </li>

                                    <li class="col-sm-6 hidden-xs pbottom--30">
                                        <!-- Post Item Start -->
                                        <div class="post--item post--layout-1">
                                            <div class="post--img">
                                                <a href="#" class="thumb"><img
                                                        src="{{asset('img/news-single-img/related-post-02.jpg')}}"
                                                        alt=""></a>
                                                <a href="#" class="cat">Fitness</a>
                                                <a href="#" class="icon"><i class="fa fa-flash"></i></a>

                                                <div class="post--info">
                                                    <ul class="nav meta">
                                                        <li><a href="#">Astaroth</a></li>
                                                        <li><a href="#">Yeasterday 03:52 pm</a></li>
                                                    </ul>

                                                    <div class="title">
                                                        <h3 class="h4"><a href="#" class="btn-link">On the other hand,
                                                                we denounce with righteous indignation and dislike
                                                                demoralized</a></h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="post--content">
                                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                                    blanditiis praesentium voluptatum deleniti atque corrupti quos
                                                    mollitia animi, id est laborum et dolorum fuga.</p>
                                            </div>

                                            <div class="post--action">
                                                <a href="#">Continue Reading... </a>
                                            </div>
                                        </div>
                                        <!-- Post Item End -->
                                    </li>
                                </ul>

                                <!-- Preloader Start -->
                                <div class="preloader bg--color-0--b" data-preloader="1">
                                    <div class="preloader--inner"></div>
                                </div>
                                <!-- Preloader End -->
                            </div>
                            <!-- Post Items End -->
                        </div>
                        <!-- Post Related End -->

                        <!-- Comment List Start -->
                        <div class="comment--list pd--30-0">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title">
                                <h2 class="h4">03 Comments</h2>

                                <i class="icon fa fa-comments-o"></i>
                            </div>
                            <!-- Post Items Title End -->

                            <ul class="comment--items nav">
                                <li>
                                    <!-- Comment Item Start -->
                                    <div class="comment--item clearfix">
                                        <div class="comment--img float--left">
                                            <img src="{{asset('img/news-single-img/comment-avatar-01.jpg')}}" alt="">
                                        </div>

                                        <div class="comment--info">
                                            <div class="comment--header clearfix">
                                                <p class="name">Karla Gleichauf</p>
                                                <p class="date">12 May 2017 at 05:28 pm</p>

                                                <a href="#" class="reply"><i class="fa fa-mail-reply"></i></a>
                                            </div>

                                            <div class="comment--content">
                                                <p>On the other hand, we denounce with righteous indignation and dislike
                                                    men who are so beguiled and demoralized by the charms of pleasure of
                                                    the moment</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comment Item End -->
                                </li>

                                <li>
                                    <!-- Comment Item Start -->
                                    <div class="comment--item clearfix">
                                        <div class="comment--img float--left">
                                            <img src="{{asset('img/news-single-img/comment-avatar-02.jpg')}}" alt="">
                                        </div>

                                        <div class="comment--info">
                                            <div class="comment--header clearfix">
                                                <p class="name">M Shyamalan</p>
                                                <p class="date">12 May 2017 at 05:28 pm</p>

                                                <a href="#" class="reply"><i class="fa fa-mail-reply"></i></a>
                                            </div>

                                            <div class="comment--content">
                                                <p>On the other hand, we denounce with righteous indignation and dislike
                                                    men who are so beguiled and demoralized by the charms of pleasure of
                                                    the moment</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comment Item End -->

                                    <ul class="comment--items nav">
                                        <li>
                                            <!-- Comment Item Start -->
                                            <div class="comment--item clearfix">
                                                <div class="comment--img float--left">
                                                    <img src="{{asset('img/news-single-img/comment-avatar-03.jpg')}}"
                                                         alt="">
                                                </div>

                                                <div class="comment--info">
                                                    <div class="comment--header clearfix">
                                                        <p class="name">Liz Montano</p>
                                                        <p class="date">12 May 2017 at 05:28 pm</p>

                                                        <a href="#" class="reply"><i class="fa fa-mail-reply"></i></a>
                                                    </div>

                                                    <div class="comment--content">
                                                        <p>On the other hand, we denounce with righteous indignation and
                                                            dislike men who are so beguiled and demoralized by the
                                                            charms of pleasure of the moment</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Comment Item End -->
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- Comment List End -->

                        <!-- Comment Form Start -->
                        <div class="comment--form pd--30-0">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title">
                                <h2 class="h4">Leave A Comment</h2>

                                <i class="icon fa fa-pencil-square-o"></i>
                            </div>
                            <!-- Post Items Title End -->

                            <div class="comment-respond">
                                <form action="#" data-form="validate">
                                    <p>Don’t worry ! Your email address will not be published. Required fields are
                                        marked (*).</p>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>
                                                <span>Comment *</span>
                                                <textarea name="comment" class="form-control" required></textarea>
                                            </label>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>
                                                <span>Name *</span>
                                                <input type="text" name="name" class="form-control" required>
                                            </label>

                                            <label>
                                                <span>Email Address *</span>
                                                <input type="email" name="email" class="form-control" required>
                                            </label>

                                            <label>
                                                <span>Website</span>
                                                <input type="text" name="website" class="form-control">
                                            </label>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Post a Comment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Comment Form End -->
                    </div>
                </div>
                <!-- Main Content End -->

                @include("web.layouts.sidebar")

            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection
