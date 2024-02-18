@extends('layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .hidden-section {
            display: none;
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

        .file-preview .image-container {
            position: relative;
            width: 150px;
            /* Fixed width for the container */
            height: 150px;
            /* Fixed height for the container */
            margin: 5px;
            /* Adjust spacing as needed */
            overflow: hidden;
            /* Ensure contents don't spill outside */
            border-radius: 4px;
            /* Rounded edges for the container */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .file-preview .image-container img {
            display: block;
            width: 100%;
            /* Ensures image takes full width of the container */
            height: 100%;
            /* Ensures image takes full height of the container */
            object-fit: cover;
            /* Makes sure the image covers the container without distortion */
            border-radius: 4px;
            /* Rounded edges for the image */
        }

        .file-preview .image-container .delete-image {
            position: absolute;
            top: 5px;
            /* Adjust for better positioning */
            right: 5px;
            /* Adjust for better positioning */
            background: rgba(0, 0, 0, 0.6);
            /* Darker background for better visibility */
            color: #fff;
            /* White icon */
            border: none;
            cursor: pointer;
            padding: 6px;
            /* Adjust for better positioning */
            border-radius: 10%;
            /* Makes the button circular */
            opacity: 0.8;
            /* Makes the button a bit transparent */
            transition: opacity 0.2s;
            /* Smooth hover effect */
        }

        .file-preview .image-container:hover .delete-image {
            opacity: 1;
            /* Makes the button fully opaque on hover */
        }
    </style>


    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المنتج</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
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
    <form action="{{ route('products.update') }}" method="post" enctype="multipart/form-data">
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
                                    value="{{ $product->name_ar }}" required>
                            </div>

                            <div class="col-lg">
                                <p class="mg-b-10">الاسم باللغه الانجليزيه</p>
                                <input class="form-control" placeholder="الاسم باللغه الانجليزيه"type="text" name="name_en"
                                    value="{{ $product->name_en }}" required>
                            </div>
                            <input type="text" value="{{ $product->id }}" name="product_id" hidden>
                            <div class="col-lg">
                                <p class="mg-b-10">الاقسام</p>
                                <select id="category" name="category" class="form-control SlectBox" required>
                                    <option value="">اختار قسم</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $category->id ? 'selected' : '' }}>
                                            {{ $item->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg">
                                <p class="mg-b-10">الاقسام الفرعية</p>
                                <select id="sub_category" name="sub_category_id" class="form-control SlectBox" required>
                                    <option value="">اختار القسم اولا</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            {{ $subcategory->id == $product->sub_category_id ? 'selected' : '' }}>
                                            {{ $subcategory->name_ar }}
                                        </option>
                                    @endforeach
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
                                            <input aria-label="Amount (to the nearest dollar)" class="form-control"
                                                placeholder="السعر" type="number" name="price" min="1"
                                                value="{{ $product->price }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <p class="mg-b-10">كود المنتج</p>
                                        <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                                            placeholder="كود المنتج" type="text" name="sku"
                                            value="{{ $product->sku }}" required>
                                    </div>


                                    <div class="col-lg-3">
                                        <p class="mg-b-10">الكميه</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الكميه" type="number" name="quantity"
                                                value="{{ $product->quantity }}" min="0" required>
                                        </div>
                                    </div>





                                    <!-- الحقل الأصلي -->
                                    <div class="col-lg-3">
                                        <p class="mg-b-10">الخصم</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الخصم" type="number" name="discount"
                                                value="{{ $product->discount }}" min="0" id="discount-field">
                                        </div>
                                    </div>

                                    <!-- الحقل الأصلي -->
                                    <div class="col-lg-3"><br>
                                        <p class="mg-b-10">الضريبه</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="price"
                                                class="form-control" placeholder="الضريبه" type="number"
                                                name="shipping_fee" min="0" id="shipping_fee"
                                                value="{{ $product->shipping_fee }}">
                                        </div>
                                    </div>
                                    <br>
                                    {{-- <div class="col-lg-3"><br>
                                        <p class="mg-b-10">ترتيب المنتج</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="ar" class="form-control"
                                                placeholder="ترتيب المنتج" type="number" name="arrange" min="1"
                                                value="{{ $product->arrange }}" required>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-3"><br>
                                        <p class="mg-b-10">وزن المنتج</p>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">#</span>
                                            </div>
                                            <input aria-describedby="basic-addon1" aria-label="ar" class="form-control"
                                                placeholder="وزن المنتج" type="number" name="weight"
                                                value="{{ $product->weight }}" required>
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
                                    @php
                                        $display = 'none';
                                        if ($product->discount != null && $product->discount > 0) {
                                            $display = 'block';
                                        }

                                    @endphp

                                    <!-- حقول الوقت -->
                                    <div class="card-body" id="discount-time-fields"
                                        style="display: {{ $display }};">
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
                                                        @php
$startdata=$product->discount_start ?? date('Y-m-d H:i:s') ; @endphp
                                                        name="discount_start" value="{{ $startdata }}">
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
                                                        @php
$enddata=$product->discount_end ?? date('Y-m-d H:i:s') ; @endphp
                                                        name="discount_end" value="{{ $enddata }}">
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

                                <textarea id="textarea2" name="description_ar" rows="15" required>{{ $product->description_ar }}</textarea>
                                <br>
                                <br>
                                <textarea id="textarea3" name="description_en" rows="15" required>{{ $product->description_en }}</textarea>
                                <input type="text" value="{{ $product->type_attribute }}" name="sectionChoice"
                                    hidden>
                            </div>
                        </div>
                    </div>


                    @if ($product->type_attribute == 'none')

                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Dropdown for section selection -->
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">اختار نوع السمه:</label>
                                                <select id="sectionChoice" class="form-control" name="sectionChoice">
                                                    <option value="none"
                                                        {{ $product->type_attribute == 'none' ? 'selected' : '' }}>-- اختار
                                                        --</option>
                                                    <option
                                                        value="colors"{{ $product->type_attribute == 'colors' ? 'selected' : '' }}>
                                                        اضافة الوان فقط</option>
                                                    <option value="sizes"
                                                        {{ $product->type_attribute == 'sizes' ? 'selected' : '' }}>اضافة
                                                        احجام فقط</option>
                                                    <option value="both"
                                                        {{ $product->type_attribute == 'both' ? 'selected' : '' }}>اضافة
                                                        احجام مع الوان</option>
                                                    <option value="none"
                                                        {{ $product->type_attribute == 'none' ? 'selected' : '' }}>لا يوجد
                                                        سمه</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Colors -->
                                        <div class="col-sm-12 col-md-6 hidden-section" id="colorsSection">
                                            <div class="form-group">
                                                <label class="col-form-label">الألوان</label>
                                                <div id="myRepeatingFields_co">
                                                    <div class="entry_co input-group">



                                                        <select id="" name="colors[]"
                                                            class="form-control SlectBox">
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


                                                        <select id="" name="attribute_size[]"
                                                            class="form-control">
                                                            <option value="">اختار الحجم</option>
                                                            @foreach ($sizes as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                                </option>
                                                            @endforeach
                                                        </select>


                                                        <select id="" name="attribute_color[]"
                                                            class="form-control">
                                                            <option value="">اختار الون</option>
                                                            @foreach ($colors as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name_ar }}
                                                                </option>
                                                            @endforeach
                                                        </select>



                                                        <input type="number" name="attribute_price[]"
                                                            class="form-control" placeholder="السعر">



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
                    @else
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($product->type_attribute == 'colors')

                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">الألوان</label>
                                                    <div id="myRepeatingFields_co">
                                                        @if (count($attributeColors) == 0)
                                                            <div class="entry_co input-group">
                                                                <select id="categorys" name="colors[]"
                                                                    class="form-control SlectBox" disabled>
                                                                    <option value="">اختار الون</option>
                                                                    @foreach ($colors as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                <input type="number" name="colors_price[]"
                                                                    class="form-control input-sm" placeholder="السعر"
                                                                    value="">
                                                                {{-- <div class="input-group-append">
                                                                    <button type="button" class="btn btn-lg btn-add-co">
                                                                        <span class="glyphicon glyphicon-plus"
                                                                            aria-hidden="true">+</span>
                                                                    </button>
                                                                </div> --}}
                                                            </div>
                                                        @else
                                                            @foreach ($attributeColors as $attributeColor)
                                                                <div class="entry_co input-group">
                                                                    <select id="categorys" name="colors[]"
                                                                        class="form-control SlectBox" disabled>
                                                                        <option value="">اختار الون</option>
                                                                        @foreach ($colors as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $attributeColor->color_id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->name_ar }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="colors[]"
                                                                        value="{{ $attributeColor->color_id }}">
                                                                    <input type="number" name="colors_price[]"
                                                                        class="form-control input-sm" placeholder="السعر"
                                                                        value="{{ $attributeColor->price }}">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-lg btn-add-co">
                                                                            @if ($attributeColor === end($attributeColors))
                                                                                <span class="glyphicon glyphicon-plus"
                                                                                    aria-hidden="true">+</span>
                                                                            @endif

                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                        <!-- Colors -->

                                        <!-- Sizes -->
                                        @if ($product->type_attribute == 'sizes')
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">الأحجام</label>
                                                    <div id="myRepeatingFields_op">
                                                        @if (empty($attributeSizes))
                                                            <div class="entry_op input-group">
                                                                <select id="category" name="sizes[]"
                                                                    class="form-control" disabled>
                                                                    <option value="">اختار الحجم</option>
                                                                    @foreach ($sizes as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                <input type="number" name="sizes_price[]"
                                                                    class="form-control input-sm" placeholder="السعر"
                                                                    value="">
                                                                {{-- <div class="input-group-append">
                                                                    <button type="button" class="btn btn-lg btn-add-op">
                                                                        <span class="glyphicon glyphicon-plus"
                                                                            aria-hidden="true">+</span>
                                                                    </button>
                                                                </div> --}}
                                                            </div>
                                                        @else
                                                            @foreach ($attributeSizes as $attributeSize)
                                                                <div class="entry_op input-group">
                                                                    <select id="category" name="sizes[]"
                                                                        class="form-control" disabled>
                                                                        <option value="">اختار الحجم</option>
                                                                        @foreach ($sizes as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $attributeSize->size_id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->name_ar }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="sizes[]"
                                                                        value="{{ $attributeSize->size_id }}">
                                                                    <input type="number" name="sizes_price[]"
                                                                        class="form-control input-sm" placeholder="السعر"
                                                                        value="{{ $attributeSize->price }}">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-lg btn-add-op">
                                                                            @if ($attributeSize === end($attributeSizes))
                                                                                <span class="glyphicon glyphicon-plus"
                                                                                    aria-hidden="true">+</span>
                                                                            @endif

                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Sizes -->

                                        <!-- Sizes and Colors -->
                                        @if ($product->type_attribute == 'both')
                                            <div class="col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">الأحجام والألوان</label>
                                                    <div id="myRepeatingFields_opp">
                                                        @if (empty($sizes_colors))
                                                            <div class="entry_opp input-group">
                                                                <select id="" name="attribute_size[]"
                                                                    class="form-control" disabled>
                                                                    <option value="">اختار الحجم</option>
                                                                    @foreach ($sizes as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <select id="" name="attribute_color[]"
                                                                    class="form-control" disabled>
                                                                    <option value="">اختار الون</option>
                                                                    @foreach ($colors as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name_ar }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="number" name="attribute_price[]"
                                                                    class="form-control" placeholder="السعر"
                                                                    value="">
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-lg btn-add-opp">
                                                                        <span class="glyphicon glyphicon-plus"
                                                                            aria-hidden="true">+</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach ($sizes_colors as $sizeColor)
                                                                <div class="entry_opp input-group">
                                                                    <select id="" name="attribute_size[]"
                                                                        class="form-control" disabled>
                                                                        <option value="">اختار الحجم</option>
                                                                        @foreach ($sizes as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $sizeColor->size_id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->name_ar }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <select id="colorSelect" name="attribute_color[]"
                                                                        class="form-control" disabled>
                                                                        <option value="">اختار الون</option>
                                                                        @foreach ($colors as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $sizeColor->color_id == $item->id ? 'selected' : '' }}>
                                                                                {{ $item->name_ar }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="attribute_size[]"
                                                                        value="{{ $sizeColor->size_id }}">
                                                                    <input type="hidden" name="attribute_color[]"
                                                                        value="{{ $sizeColor->color_id }}">

                                                                    <input type="number" name="attribute_price[]"
                                                                        class="form-control" placeholder="السعر"
                                                                        value="{{ number_format($sizeColor->price, 2, '.', '') }}">

                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-lg btn-add-opp">
                                                                            @if ($sizeColor === end($sizes_colors))
                                                                                <span class="glyphicon glyphicon-plus"
                                                                                    aria-hidden="true">+</span>
                                                                            @endif
                                                                        </button>
                                                                    </div>


                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                        @endif
                                        <!-- Sizes and Colors -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif




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
                                                    <input type="file" class="dropify"
                                                        data-default-file="{{ URL::asset($product->image) }}"
                                                        data-height="200" name="image" enctype="multipart/form-data" />
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <label for="measurement_guide" class="col-form-label">دليل القياس
                                                        (اختياري)</label>
                                                    <input type="file" class="dropify"
                                                        data-default-file="{{ URL::asset($product->measurement_guide) }}"
                                                        data-height="200" name="measurement_guide"
                                                        enctype="multipart/form-data" />
                                                </div>

                                                <div class="col-sm-12 col-md-4" style="margin-top: 35px;">
                                                    <textarea class="form-control" placeholder="اضافة ملحوظه لدليل القياس" rows="3"
                                                        name="description_measurement_guide"> {{ $product->description_measurement_guide }} </textarea>
                                                </div>
                                            </div>




                                            <div class="file-upload">
                                                <p>معرض الصور</p>
                                                <input id="multimg" type="file" name="images[]"
                                                    enctype="multipart/form-data" multiple>
                                                <label for="multimg">
                                                    <span>اختار صورة</span>
                                                    <i class="fas fa-upload"></i>
                                                </label>
                                                <div class="file-preview">
                                                    @foreach ($product->images as $image)
                                                        <div class="image-container">
                                                            <img src="{{ URL::asset($image->image) }}"
                                                                alt="Image Preview">
                                                            <button type="button" class="delete-image"
                                                                data-id="{{ $image->id }}"><i
                                                                    class="fas fa-trash"></i></button>

                                                        </div>
                                                    @endforeach
                                                </div>


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
    {{-- ----------------------------------Start--------------- --}}
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

        //  only colors
        $(function() {
            $(document)
                .on("click", ".btn-add-co", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_co:first"),
                        currentEntry = $(this).parents(".entry_co:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);

                    // Remove 'disabled' attribute from select fields
                    newEntry.find("select").removeAttr("disabled");

                    // Clear the input values within the cloned entry
                    newEntry.find("input").val("");

                    // Change the button to a removal button
                    newEntry.find(".btn-add-co")
                        .removeClass("btn-add-co")
                        .addClass("btn-remove-co")
                        .removeClass("btn-success")
                        .addClass("btn-danger")
                        .html("-");
                })
                .on("click", ".btn-remove-co", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_co:first").remove();
                    return false;
                });
        });
        //  only sizes
        $(function() {
            $(document)
                .on("click", ".btn-add-op", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_op:first"),
                        currentEntry = $(this).parents(".entry_op:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);

                    // Remove 'disabled' attribute from select fields
                    newEntry.find("select").removeAttr("disabled");

                    // Clear the input values within the cloned entry
                    newEntry.find("input").val("");

                    // Change the button to a removal button
                    newEntry.find(".btn-add-op")
                        .removeClass("btn-add-op")
                        .addClass("btn-remove-op")
                        .removeClass("btn-success")
                        .addClass("btn-danger")
                        .html("-");
                })
                .on("click", ".btn-remove-op", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_op:first").remove();
                    return false;
                });
        });







        //  sizes and colors
        $(function() {
            $(document)
                .on("click", ".btn-add-opp", function(e) {
                    e.preventDefault();
                    var controlForm = $("#myRepeatingFields_opp:first"),
                        currentEntry = $(this).parents(".entry_opp:first"),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);

                    // Remove 'disabled' attribute from select fields
                    newEntry.find("select").removeAttr("disabled");

                    // Clear the input values within the cloned entry
                    newEntry.find("input").val("");

                    // Change the button to a removal button
                    newEntry.find(".btn-add-opp")
                        .removeClass("btn-add-opp")
                        .addClass("btn-remove-opp")
                        .removeClass("btn-success")
                        .addClass("btn-danger")
                        .html("-");
                })
                .on("click", ".btn-remove-opp", function(e) {
                    e.preventDefault();
                    $(this).parents(".entry_opp:first").remove();
                    return false;
                });
        });
    </script>

    {{-- ------------------------------------------end--------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-image');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {


                    const imageId = e.currentTarget.getAttribute('data-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    var url = `{{ route('delete.image', ['id' => ':imageId']) }}`;
                    url = url.replace(':imageId', imageId);
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            // other necessary configurations like headers, etc.
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('sucsssssssssssss');

                                // function findAncestor(el, cls) {
                                //     while ((el = el.parentElement) && !el.classList.contains(
                                //             cls));
                                //     return el;
                                // }

                                // const imageContainer = findAncestor(e.currentTarget,
                                //     'image-container');
                                // if (imageContainer) {
                                //     imageContainer.remove();
                                // }
                                // Optionally, remove the image from the DOM or notify the user about successful deletion
                                e.target.closest('.image-container').remove();
                            } else {
                                console.error('Error deleting the image:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error XXXX :', error);
                        });



















                });
            });
        });
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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>

    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('textarea');
    </script>


    <script>
        CKEDITOR.replace('textarea2');
    </script>

    <script>
        CKEDITOR.replace('textarea3');
    </script>
    <script>
        CKEDITOR.replace('textarea4');
    </script>
    <script>
        document.getElementById('singleimage').addEventListener('change', function() {
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
        document.getElementById('multimg').addEventListener('change', function() {
            var previewContainer = document.querySelector('.file-preview');

            var files = this.files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');

                    var imgElement = document.createElement('img');
                    imgElement.src = event.target.result;

                    imgContainer.appendChild(imgElement);
                    previewContainer.appendChild(imgContainer);
                }

                reader.readAsDataURL(files[i]);
            }
        });

        // Add event listener for delete buttons
        document.querySelector('.file-preview').addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-image')) {
                var imageId = e.target.dataset.id;

                // Call API to delete the image
                deleteImageFromServer(imageId);

                // Remove the image container from DOM
                e.target.parentElement.remove();
            }
        });
    </script>



    <script>
        const discountField = document.getElementById('discount-field');
        const discountTimeFields = document.getElementById('discount-time-fields');

        // دالة لإظهار حقول الوقت
        function showDiscountTimeFields() {
            discountTimeFields.style.display = 'block';
        }

        // دالة لإخفاء حقول الوقت
        function hideDiscountTimeFields() {
            discountTimeFields.style.display = 'none';
        }

        // ربط حدث تغيير حقل الخصم بدالتي الإظهار والإخفاء
        discountField.addEventListener('change', function() {
            // إذا كان القيمة غير صفرية، أظهر حقول الوقت، وإلا أخفها
            if (discountField.value > 0) {
                showDiscountTimeFields();
            } else {
                hideDiscountTimeFields();
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
@endsection
