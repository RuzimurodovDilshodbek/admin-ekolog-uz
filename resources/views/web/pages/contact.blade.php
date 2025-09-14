@extends("web.layouts.app")



@section("content")

    <!-- Main Breadcrumb Start -->
    <div class="main--breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="home-1.html" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>
                <li class="active"><span>Contact</span></li>
            </ul>
        </div>
    </div>
    <!-- Main Breadcrumb End -->


    <!-- Map Start -->
    <div class="map--fluid mtop--30" data-trigger="map" data-map-latitude="23.790546" data-map-longitude="90.375583" data-map-zoom="16" data-map-marker="[[23.790546, 90.375583]]"></div>
    <!-- Map End -->

    <!-- Contact Section Start -->
    <div class="contact--section pd--30-0">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 ptop--30 pbottom--30">
                    <!-- Contact Info Start -->
                    <div class="contact--info">
                        <ul class="nav">
                            <li>
                                <div class="title">
                                    <h3 class="h5"><i class="fa fa-phone-square"></i>Telephone</h3>
                                </div>

                                <div class="content">
                                    <p><a href="tel:0055667788991122">0055667788991122</a></p>
                                    <p><a href="tel:0055667788991122">0055667788991122</a></p>
                                </div>
                            </li>

                            <li>
                                <div class="title">
                                    <h3 class="h5"><i class="fa fa-envelope-open"></i>E-mail Address</h3>
                                </div>

                                <div class="content">
                                    <p><a href="mailto:example@example.com">example@example.com</a></p>
                                    <p><a href="mailto:example@example.com">example@example.com</a></p>
                                </div>
                            </li>

                            <li>
                                <div class="title">
                                    <h3 class="h5"><i class="fa fa-map-marker"></i>Address</h3>
                                </div>

                                <div class="content">
                                    <p>House - 896, East Shewrapara</p>
                                    <p>Kafrul, Dhaka -1219, Bangladesh</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Contact Info End -->
                </div>

                <div class="col-md-9 col-sm-8 ptop--30 pbottom--30">
                    <!-- Comment Form Start -->
                    <div class="comment--form">
                        <div class="comment-respond">
                            <form action="forms/contact-form.php" data-form="ajax">
                                <div class="status"></div>

                                <div class="row">
                                    <div class="col-xs-6 col-xxs-12">
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

                                    <div class="col-xs-6 col-xxs-12">
                                        <label>
                                            <span>Comment *</span>
                                            <textarea name="message" class="form-control" required></textarea>
                                        </label>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Comment Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->


@endsection
