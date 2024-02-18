{{-- <!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            background: #C1908B;
        }

        .container {
            max-width: 75%;
            margin: auto;
            height: 80vh;
            margin-top: 5%;
            background: white;
            box-shadow: 5px 5px 10px 3px rgba(0, 0, 0, 0.3);
        }

        .left,
        .right {
            width: 50%;
            padding: 30px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .flex1 {
            display: flex;
        }

        .main_image {
            width: auto;
            height: auto;
        }

        .option img {
            width: 75px;
            height: 75px;
            padding: 10px;
        }

        .right {
            padding: 50px 100px 50px 50px;
        }

        h3 {
            color: #af827d;
            margin: 20px 0 20px 0;
            font-size: 25px;
        }

        h5,
        p,
        small {
            color: #837D7C;
        }

        h4 {
            color: red;
        }

        p {
            margin: 20px 0 50px 0;
            line-height: 25px;
        }

        h5 {
            font-size: 15px;
        }

        label,
        .add span,
        .color span {
            width: 25px;
            height: 25px;
            background: #000;
            border-radius: 50%;
            margin: 20px 10px 20px 0;
        }

        .color span:nth-child(2) {
            background: #EDEDED;
        }

        .color span:nth-child(3) {
            background: #D5D6D8;
        }

        .color span:nth-child(4) {
            background: #EFE0DE;
        }

        .color span:nth-child(5) {
            background: #AB8ED1;
        }

        .color span:nth-child(6) {
            background: #F04D44;
        }

        .add label,
        .add span {
            background: none;
            border: 1px solid #C1908B;
            color: #C1908B;
            text-align: center;
            line-height: 25px;
        }

        .add label {
            padding: 10px 30px 0 20px;
            border-radius: 50px;
            line-height: 0;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
            background: #C1908B;
            color: white;
            margin-top: 20%;
            border-radius: 30px;
        }

        @media only screen and (max-width:768px) {
            .container {
                max-width: 90%;
                margin: auto;
                height: auto;
            }

            .left,
            .right {
                width: 100%;
            }

            .container {
                flex-direction: column;
            }
        }

        @media only screen and (max-width:511px) {
            .container {
                max-width: 100%;
                height: auto;
                padding: 10px;
            }

            .left,
            .right {
                padding: 0;
            }

            img {
                width: 100%;
                height: 100%;
            }

            .option {
                display: flex;
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <section>
        <div class="container flex">
            <div class="left">





                <div class="main_image">
                    <img src="{{ asset('images/p1.jpg') }}" class="slide">
                </div>
                <div class="option flex">
                    <img src="{{ asset('images/p1.jpg') }}" onclick="img(asset('images/p1.jpg'))">
                    <img src="{{ asset('images/p2.jpg') }}" onclick="img(asset('images/p2.jpg'))">
                    <img src="{{ asset('images/p3.jpg') }}" onclick="img(asset('images/p3.jpg'))">
                    <img src="{{ asset('images/p4.jpg') }}" onclick="img(asset('images/p4.jpg'))">
                    <img src="{{ asset('images/p5.jpg') }}" onclick="img(asset('images/p5.jpg'))">
                    <img src="{{ asset('images/p6.jpg') }}" onclick="img(asset('images/p6.jpg'))">
                </div>
            </div>
            <div class="right">
                <h3>Beats Solo3 Wireless</h3>
                <h4> <small>$</small>999.99 </h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. </p>
                <h5>Color-Rose Gold</h5>
                <div class="color flex1">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <h5>Number</h5>
                <div class="add flex1">
                    <span>-</span>
                    <label>1</label>
                    <span>+</span>
                </div>

                <button>Add to Bag</button>
            </div>
        </div>
    </section>
    <script>
        function img(anything) {
            document.querySelector('.slide').src = anything;
        }

        function change(change) {
            const line = document.querySelector('.home');
            line.style.background = change;
        }
    </script>
</body>

</html> --}}
{{-- // 38090 --}}
@extends('layouts.master2')
@section('css')
    <!--Internal  Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <style>
        .bg-primary-transparent {

            /* background: #C1908B !important; */
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المتجر</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل المنتج</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body h-100">
                    <div class="row row-sm ">
                        <div class="col-xl-5 col-lg-12 col-md-12">
                            <div class="preview-pic tab-content">
                                @foreach ($product->images as $index => $image)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="pic-{{ $index + 1 }}">
                                        <img src="{{ asset($image->image) }}" alt="image" />
                                    </div>
                                @endforeach
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                @foreach ($product->images as $index => $image)
                                    <li class="{{ $index === 0 ? 'active' : '' }}">
                                        <a data-target="#pic-{{ $index + 1 }}" data-toggle="tab">
                                            <img src="{{ asset($image->image) }}" alt="image" />
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                            <h4 class="product-title mb-1">{{ $product->name }}</h4>
                            <p class="text-muted tx-13 mb-1"></p>
                            <div class="rating mb-1">
                                {{-- <div class="stars">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star text-muted"></span>
                                    <span class="fa fa-star text-muted"></span>
                                </div> --}}
                                <span class="review-no">{{ $product->views }} @if ($locale == 'ar')
                                        المشاهدات
                                    @else
                                        Views
                                    @endif </span>
                            </div>
                            <h6 class="price">
                                @if ($locale == 'ar')
                                    السعر الرئيسي
                                @else
                                    main price
                                @endif :
                                <span class="h3 ml-2">{{ $product->final_price }}</span>
                            </h6>


                            <p class="product-description">{{ $product->description }}</p>



                            <div class="sizes d-flex">
                                @if ($locale == 'ar')
                                    الاحجام
                                @else
                                    sizes
                                @endif :
                                @foreach ($product->attribute as $attr)
                                    @if (isset($attr['size']))
                                        <span class="size d-flex" data-toggle="tooltip"
                                            title="{{ $attr['size']['name_' . $locale] }}">
                                            <label class="rdiobox mb-0">
                                                <input checked="" name="rdio" type="radio">
                                                <span class="font-weight-bold">{{ $attr['size']['name_en'] }}</span>
                                            </label>
                                        </span>
                                    @endif
                                @endforeach
                            </div>


                            <div class="colors d-flex mr-3 mt-2">
                                <span class="mt-2">
                                    @if ($locale == 'ar')
                                        الالوان
                                    @else
                                        colors
                                    @endif :
                                </span>
                                <div class="row gutters-xs mr-4">
                                    @foreach ($product->attribute as $attr)
                                        @if (isset($attr['color']))
                                            <div class="mr-2">
                                                <label class="colorinput">
                                                    <input name="color" type="radio"
                                                        value="{{ $attr['color']['color_code'] }}"
                                                        class="colorinput-input">
                                                    <div
                                                        style="width: 24px; height: 24px; background-color: {{ $attr['color']['color_code'] }};">
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach



                                </div>
                            </div>




                            <div class="d-flex  mt-2">
                                <div class="mt-2 product-title">
                                    @if ($locale == 'ar')
                                        المتوفر في المخزون
                                    @else
                                        Available in stock
                                    @endif :
                                </div>
                                <div class="d-flex ml-2">
                                    <ul class=" mb-0 qunatity-list">
                                        <li>
                                            <div class="form-group">
                                                <select name="quantity" id="select-countries17"
                                                    class="form-control nice-select wd-100">
                                                    <option value="{{ $product->quantity }}" selected="">
                                                        {{ $product->quantity }}</option>
                                                    {{-- @for ($i = 1; $i < $product->quantity; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor --}}


                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="action">

                                <button class="copy_link btn btn-danger" id="copy_link" type="button">
                                    @if ($locale == 'ar')
                                        نسخ رابط المنتج
                                    @else
                                        Copy the product link
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!-- Internal Nice-select js-->
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>
    <script>
        var copyBtn = document.getElementById('copy_link');
        // var linkInput = document.getElementById('product_link');
        // var pageUrl = window.location.href;
        copyBtn.addEventListener('click', function() {
            const url = new URL(window.location.href);
            url.searchParams.delete('_token');
            const newUrl = url.toString();
            navigator.clipboard.writeText(newUrl);
            alert('تم نسخ الرابط بنجاح!');
        });
    </script>
@endsection
