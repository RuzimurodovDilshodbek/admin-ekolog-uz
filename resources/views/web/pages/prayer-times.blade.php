@extends("web.layouts.app")



@section("content")

    <!-- Main Breadcrumb Start -->
{{--    <div class="main--breadcrumb">--}}
{{--        <div class="container">--}}
{{--            <ul class="breadcrumb">--}}
{{--                <li><a href="home-1.html" class="btn-link"><i class="fa fm fa-home"></i>Home</a></li>--}}
{{--                <li class="active"><span>Namoz vaqtlari</span></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Main Breadcrumb End -->


    <!-- Prayer Section Start -->
    <div class="contact--section pd--30-0">
        <div class="container">
            <div class="row">
                <div class="product--details tab-content ptop--30">
                    <!-- Tab Pane Start -->
                    <div class="tab-pane fade in active" id="productDetails01">
                        <div class="content clearfix">
                            <h2 class="text-center mb-2">Намоз вақтлари Тошкент вақти бўйича</h2>

                            <table style="width: 100%">
                                <tbody>
                                <tr>
                                    <td>ражаб / шаъбон</td>
                                    <td>февраль</td>
                                    <td>Ҳафта куни </td>
                                    <td>Тонг(Саҳарлик)</td>
                                    <td>Қуёш </td>
                                    <td>Пешин</td>
                                    <td>Аср</td>
                                    <td>Шом(Ифтор)</td>
                                    <td>Хуфтон</td>
                                </tr>
                                @for ($i = 0; $i < 30; $i++)
                                    <tr>
                                        <td>10
                                        <td>1</td>
                                        <td>Чоршанба</td>
                                        <td>06:16</td>
                                        <td>07:35</td>
                                        <td>12:37</td>
                                        <td>15:57</td>
                                        <td>17:44</td>
                                        <td> 18:57</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->


@endsection
