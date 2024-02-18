@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .hidden-section {
            display: none;
        }
    </style>
    <style>
        .file-upload {
            position: relative;
            display: inline-block;
        }

        color-input-group {
            display: flex;
            align-items: center;
        }

        .color-input {
            margin-right: 10px;
        }

        .price-input {
            width: 150px;
        }


        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload label {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .file-upload label span {
            margin-right: 10px;
        }

        .file-preview {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
        }

        .file-preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المنتج</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                    منتج</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        {{ method_field('post') }}
        {{ csrf_field() }}
        <div class="row">

            {{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------ --}}

            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <!--div-->
                <div class="card">



                    <div class="card-body">
                        {{-- | name ar | en | cateogery | sub cateogery --}}
                        <div class="row row-sm">
                            <div class="col-lg">
                                <p class="mg-b-10">الاسم باللغه العربيه</p>
                                <input class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}"
                                    placeholder="الاسم باللغه العربيه" type="text" name="name_ar"
                                    value="{{ old('name_ar') }}" required>
                            </div>

                            <div class="col-lg">
                                <p class="mg-b-10">الاسم باللغه الانجليزيه</p>
                                <input class="form-control" placeholder="الاسم باللغه الانجليزيه"type="text" name="name_en"
                                    value="{{ old('name_en') }}" required>
                            </div>

                            <div class="col-lg">
                                <p class="mg-b-10">الاقسام</p>
                                <select id="category" name="category" class="form-control SlectBox" required>
                                    <option value="">اختار قسم</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_ar }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg">
                                <p class="mg-b-10">الاقسام الفرعيه</p>
                                <select id="sub_category" name="sub_category_id" class="form-control SlectBox">
                                    <option value="">اختار القسم اولا</option>
                                </select>
                            </div>

                        </div>
                    </div>








                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    سعر المنتج + المخزون
                                </div>
                                <br>
                                <br>
                                <div class="row row-sm">



                                    <div class="col-lg-3">
                                        <p class="mg-b-10">السعر الرئيسي</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input id="price" aria-label="Amount (to the nearest dollar)"
                                                class="form-control" placeholder="السعر" type="number" name="price"
                                                min="1" required oninput="calculateDiscount()">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <p class="mg-b-10">كود المنتج</p>
                                        <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                                            placeholder="كود المنتج" type="text" name="sku"
                                            value="{{ old('sku') }}" required>
                                    </div>
                                    @php
                                        $user = Auth::user();
                                    @endphp

                                    @if ($user->type != 'admin')
                                        <div class="col-lg-3">
                                            <p class="mg-b-10">مستحقاتك</p>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input aria-label="Discounted amount" class="form-control"
                                                    placeholder="مستحقاتك" type="text" id="discountedPrice" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-lg-3">
                                        <p class="mg-b-10">الكميه</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الكميه" type="number" name="quantity"
                                                min="1" required>
                                        </div>
                                    </div>




                                    <!-- الحقل الأصلي -->
                                    <div class="col-lg-3">
                                        @if ($user->type != 'admin')
                                            <br>
                                        @endif
                                        <p class="mg-b-10">الخصم (سعر ثابت)</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الخصم" type="number" name="discount"
                                                min="0" id="discount-field">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        @if ($user->type != 'admin')
                                            {{-- <br> --}}
                                        @endif
                                        <p class="mg-b-10">الخصم (نسبه مئويه)</p>
                                        <br>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الخصم" type="number"
                                                name="percentage_discount" min="0" id="percentage_discount-field"
                                                readonly>
                                        </div>
                                    </div>
                                    <!-- الحقل الأصلي -->
                                    <div class="col-lg-3">
                                        <br>
                                        <p class="mg-b-10">الضريبه</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الضريبه" type="number"
                                                name="shipping_fee" min="1" id="shipping_fee">
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3"><br>
                                        <p class="mg-b-10">ترتيب المنتج</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="ar" class="form-control"
                                                placeholder="ترتيب المنتج" type="number" name="arrange" min="1"
                                                required>
                                        </div>
                                    </div> --}}




                                    <div class="col-lg-3"><br>
                                        <p class="mg-b-10">وزن المنتج</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="ar" class="form-control"
                                                placeholder="وزن المنتج" type="number" name="weight" min="0"
                                                required>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3"><br>
                                        <div class="col-lg">
                                            <p class="mg-b-10">نوع المنتج</p>
                                            <select id="is_gift" name="is_gift" class="form-control SlectBox">
                                                <option value="0">منتج عادي</option>
                                                <option value="1">داخل مجموعة الهدايا</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <!-- حقول الوقت -->
                                    <div class="card-body" id="discount-time-fields" style="display: none;">
                                        <div class="row row-sm">
                                            <div class="col-md-4">
                                                <label for="datetimepicker2">وقت البدء</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" id="datetimepicker2" type="text"
                                                        name="discount_start" value="{{ date('Y-m-d H:i:s') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="datetimepicker1">وقت الانتهاء</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" id="datetimepicker1" type="text"
                                                        name="discount_end"
                                                        value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    وصف المنتج
                                </div>
                                <br>

                                <textarea id="textarea2" name="description_ar" rows="15">الوصف باللغه العربيه</textarea>
                                <br>
                                <br>
                                <textarea id="textarea3" name="description_en" rows="15">الوصف باللغه الانجليزيه</textarea>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Dropdown for section selection -->
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">اختار نوع السمه:</label>
                                            <select id="sectionChoice" class="form-control" name="sectionChoice">
                                                <option value="none">-- اختار --</option>
                                                <option value="colors">اضافة الوان فقط</option>
                                                <option value="sizes">اضافة احجام فقط</option>
                                                <option value="both">اضافة احجام مع الوان</option>
                                                <option value="none">لا يوجد سمه</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Colors -->
                                    <div class="col-sm-12 col-md-6 hidden-section" id="colorsSection">
                                        <div class="form-group">
                                            <label class="col-form-label">الألوان</label>
                                            <div id="myRepeatingFields_co">
                                                <div class="entry_co input-group">



                                                    <select id="" name="colors[]" class="form-control SlectBox">
                                                        <option value="">اختار الون</option>
                                                        @foreach ($colors as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <input type="number" name="colors_price[]"
                                                        class="form-control input-sm" placeholder="السعر">

                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-lg btn-add-co">
                                                            <span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true">+</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sizes -->
                                    <div class="col-sm-12 col-md-6 hidden-section" id="sizesSection">
                                        <div class="form-group">
                                            <label class="col-form-label">الأحجام</label>
                                            <div id="myRepeatingFields_op">
                                                <div class="entry_op input-group">


                                                    <select id="category" name="sizes[]" class="form-control">
                                                        <option value="">اختار الحجم</option>
                                                        @foreach ($sizes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <input type="number" name="sizes_price[]"
                                                        class="form-control input-sm" placeholder="السعر">

                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-lg btn-add-op">
                                                            <span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true">+</span>
                                                        </button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sizes and Colors -->
                                    <div class="col-sm-12 col-md-6 hidden-section" id="bothSection">
                                        <div class="form-group">
                                            <label class="col-form-label">الأحجام والألوان</label>
                                            <div id="myRepeatingFields_opp">
                                                <div class="entry_opp input-group">


                                                    <select id="" name="attribute_size[]" class="form-control">
                                                        <option value="">اختار الحجم</option>
                                                        @foreach ($sizes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </select>


                                                    <select id="" name="attribute_color[]" class="form-control">
                                                        <option value="">اختار الون</option>
                                                        @foreach ($colors as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </select>



                                                    <input type="number" name="attribute_price[]" class="form-control"
                                                        placeholder="السعر">



                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-lg btn-add-opp">
                                                            <span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true">+</span>
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">


                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <h6 class="card-title mb-1">رفع الصور</h6>
                                            </div>

                                            <br>

                                            <div class="row mb-4">
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="image" class="col-form-label">صورة المنتج</label>
                                                    <input type="file" class="dropify" data-default-file="" required
                                                        data-height="200" name="image" enctype="multipart/form-data" />
                                                </div>

                                                {{-- <div class="col-sm-12 col-md-4">
                                                    <label for="measurement_guide" class="col-form-label">دليل القياس
                                                        (اختياري)</label>
                                                    <input type="file" class="dropify" data-default-file=""
                                                        data-height="200" name="measurement_guide"
                                                        enctype="multipart/form-data" />
                                                </div> --}}
                                                {{-- <div class="col-sm-12 col-md-4" style="margin-top: 35px;">
                                                    <textarea class="form-control" placeholder="اضافة ملحوظه لدليل القياس" rows="3"
                                                        name="description_measurement_guide"></textarea>
                                                </div> --}}

                                            </div>


                                            <div class="file-upload">
                                                <p>معرض الصور </p>
                                                <input id="multimg" type="file" name="images[]"
                                                    enctype="multipart/form-data" multiple required>
                                                <label for="multimg">
                                                    <span> اختار صوره</span>
                                                    <i class="fas fa-upload"></i>
                                                </label>
                                                <div class="file-preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <br>
                    <p></p>
                    <button type="submit" class="btn btn-danger"
                        style="width:200px; height:50px; background-color: blue; color:white; margin: 0 auto;">حفظ
                    </button>


                </div>
            </div>
        </div>


    </form>
    <!-- row closed -->
@endsection
@section('js')
    <script>
        function showDiscountTimeFields() {
            discountTimeFields.style.display = 'block';
        }

        function hideDiscountTimeFields() {
            discountTimeFields.style.display = 'none';
        }

        const discountField = document.getElementById('discount-field');
        const percentageDiscountField = document.getElementById('percentage_discount-field');
        const discountTimeFields = document.getElementById(
            'discount-time-fields'); // Define the discountTimeFields variable

        discountField.addEventListener('input', function() {
            const discount = parseFloat(discountField.value);
            var price = document.getElementById('price').value;
            if (discount <= price) {
                if (!isNaN(discount) && discount >= 0) {
                    const percentageDiscount = (discount / price) * 100;
                    percentageDiscountField.value = percentageDiscount.toFixed(2);
                } else {
                    percentageDiscountField.value = '';
                }

                if (discountField.value > 0) {
                    showDiscountTimeFields();
                } else {
                    hideDiscountTimeFields();
                }
            } else {
                discountField.value = '';
                percentageDiscountField.value = '';
                hideDiscountTimeFields();
            }
        });
    </script>

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#sectionChoice").change(function() {
                // Hide all sections
                $(".hidden-section").hide();

                // Show the chosen section
                const choice = $(this).val();
                if (choice === "colors") {
                    $("#colorsSection").show();
                } else if (choice === "sizes") {
                    $("#sizesSection").show();
                } else if (choice === "both") {
                    $("#bothSection").show();
                }
            });
        });
    </script>
    <script>
        // Set custom validation message for required fields
        var requiredFields = document.querySelectorAll('[required]');
        for (var i = 0; i < requiredFields.length; i++) {
            requiredFields[i].addEventListener('invalid', function() {
                if (this.value.trim() === "") {
                    this.setCustomValidity('لا يمكنك ترك هذه الحقل فارغا');
                } else {
                    this.setCustomValidity('قيمه غير صحيحه');
                }
            });
            requiredFields[i].addEventListener('input', function() {
                this.setCustomValidity(
                    ''); // Reset custom validity message on input to ensure new message can be set
            });
        }
    </script>
    <script>
        $(function() {
            $(document)
                .on("click", ".btn-add", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields:first"),
                        currentEntry = $(this).parents(".entry:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find("input").val("");
                    controlForm.find(".entry:not(:last) .btn-add").removeClass("btn-add").addClass("btn-remove")
                        .removeClass("btn-success").addClass("btn-danger").html("-");
                })
                .on("click", ".btn-remove", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry:first").remove();
                    return false;
                });
        });
        $(function() {
            $(document)
                .on("click", ".btn-add-co", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_co:first"),
                        currentEntry = $(this).parents(".entry_co:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find("input").val("");
                    controlForm.find(".entry_co:not(:last) .btn-add-co").removeClass("btn-add-co").addClass(
                        "btn-remove-co").removeClass("btn-success").addClass("btn-danger").html("-");
                })
                .on("click", ".btn-remove-co", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_co:first").remove();
                    return false;
                });
        });
        $(function() {
            $(document)
                .on("click", ".btn-add-op", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_op:first"),
                        currentEntry = $(this).parents(".entry_op:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find("input").val("");
                    controlForm.find(".entry_op:not(:last) .btn-add-op").removeClass("btn-add-op").addClass(
                        "btn-remove-op").removeClass("btn-success").addClass("btn-danger").html("-");
                })
                .on("click", ".btn-remove-op", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_op:first").remove();
                    return false;
                });
        });







        $(function() {
            $(document)
                .on("click", ".btn-add-opp", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_opp:first"),
                        currentEntry = $(this).parents(".entry_opp:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find("input").val("");
                    controlForm.find(".entry_opp:not(:last) .btn-add-opp").removeClass("btn-add-opp").addClass(
                        "btn-remove-opp").removeClass("btn-success").addClass("btn-danger").html("-");
                })
                .on("click", ".btn-remove-opp", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_opp:first").remove();
                    return false;
                });
        });
    </script>
    <script type="text/javascript">
        function calculateDiscount() {
            var price = document.getElementById('price').value;
            var discountedPrice = price * (1 - 0.075); // Calculates price after a 30% discount
            document.getElementById('discountedPrice').value = discountedPrice.toFixed(
                2); // Displays the discounted price in the read-only input field, rounded to 2 decimal places
        }
    </script>

    <script>
        $(function() {
            // Multiple images preview in browser



            var imagesPreview = function(input, placeToInsertImagePreview) {



                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                placeToInsertImagePreview);
                        }
                        console.log("Selected picture name: 111");
                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };
            console.log("Selected picture name: 222");
            $('#gallery-photo-add').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });

        });
    </script>


    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>


    <script>
        document.getElementById('multimg').addEventListener('change', function() {
            var previewContainer = document.querySelector('.file-preview');
            previewContainer.innerHTML = '';

            var files = this.files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var imgElement = document.createElement('img');
                    imgElement.src = event.target.result;
                    previewContainer.appendChild(imgElement);
                }

                reader.readAsDataURL(files[i]);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subCategoryDropdown = $('#sub_category');

                if (categoryId) {
                    // Make an AJAX request to fetch the subsections based on the selected section
                    $.ajax({
                        url: '{{ route('getSubsections') }}',
                        type: 'GET',
                        data: {
                            category: categoryId
                        },
                        success: function(response) {
                            console.log(response);
                            console.log("------------------");
                            console.log(response.data);
                            // Clear previous options
                            subCategoryDropdown.empty();

                            // Add default option
                            // subCategoryDropdown.append(
                            //     '<option value="">Select a subsection</option>');

                            // Populate the subsection dropdown with the received data
                            $.each(response, function(key, value) {
                                console.log(value + key);
                                subCategoryDropdown.append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    // Clear the subsection dropdown if no section is selected
                    subCategoryDropdown.empty();
                }
            });
        });
    </script>



    <script>
        CKEDITOR.replace('textarea');
        CKEDITOR.replace('textarea2');
        CKEDITOR.replace('textarea3');
        CKEDITOR.replace('textarea4');
    </script>
@endsection
