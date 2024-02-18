@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبًا بكم مرة أخرى!</h2>
                <p class="mg-b-0">قالب لوحة مراقبة المبيعات..</p>
            </div>
        </div>
        {{-- <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">Customer Ratings</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">Online Sales</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">Offline Sales</label>
                <h5>783,675</h5>
            </div>
        </div> --}}
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white"> عدد المنتجات</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalProduct }}</h4>
                                {{-- <p class="mb-0 tx-12 text-white op-7">هذه الاحصائيه لاخر شهر</p> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي عدد الطلبات</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalOrder }}</h4>
                                {{-- <p class="mb-0 tx-12 text-white op-7">هذه الاحصائيه لاخر شهر</p> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">مجموع الارباح</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalRevenue }}</h4>
                                {{-- <p class="mb-0 tx-12 text-white op-7">هذه الاحصائيه لاخر شهر</p> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">مجموع عدد مستخدمين التطبيق</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $totalUser }}</h4>
                                {{-- <p class="mb-0 tx-12 text-white op-7">هذه الاحصائيه لاخر شهر</p> --}}
                            </div>

                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">حالة الطلب </h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">حالة الطلب والتتبع. تتبع طلبك من تاريخ الشحن إلى الوصول. للبدء.</p>
                </div>
                <div class="card-body">
                    <div class="total-revenue">


                        <div>
                            <h4>{{ $Ordercompleted }}</h4>
                            <label><span class="bg-primary"></span>مكتمل</label>
                        </div>



                        <div>
                            <h4>{{ $Orderpendings }}</h4>
                            <label><span class="bg-danger"></span>قيد الانتظار</label>
                        </div>



                        <div>
                            <h4>{{ $Ordercancelled }}</h4>
                            <label><span class="bg-warning"></span>فشل</label>
                        </div>


                    </div>
                    {{--  --}}
                    <div id="bar" class="sales-bar mt-4"></div>

                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">العملاء في الآونة الأخيرة</h3>
                </div>
                <div class="card-body p-0 customers mt-1">
                    <div class="list-group list-lg-group list-group-flush">
                        @foreach ($last5Customers as $item)
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto"
                                        src="{{ URL::asset('assets/img/faces/3.jpg') }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-0">
                                                <h5 class="mb-1 tx-15">{{ $item->name }}</h5>
                                                <p class="mb-0 tx-13 text-muted">معرف المستخدم : {{ $item->id }}<span
                                                        class="text-success ml-2"> البريد:{{ $item->email }}</span>
                                                    {{--  --}}
                                                    {{--  --}}
                                                </p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">المنتجات الاكثر مبيعا</h3>
                </div>
                <div class="card-body p-0 customers mt-1">
                    <div class="list-group list-lg-group list-group-flush">
                        @foreach ($topSellingProducts as $item)
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto"
                                        src="{{ URL::asset($item->product->image) }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-0">
                                                <h5 class="mb-1 tx-15">{{ $item->product->name_ar }}</h5>
                                                <p class="mb-0 tx-13 text-muted"> معرف المنتج :
                                                    {{ $item->product->id }}<span class="text-success ml-2"> عدد مرات
                                                        البيع :
                                                        {{ $item->total_sales }}</span>
                                                </p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">المنتجات الاكثر مشاهدة</h3>
                </div>
                <div class="card-body p-0 customers mt-1">
                    <div class="list-group list-lg-group list-group-flush">
                        @foreach ($mostViewedProducts as $item)
                            <div class="list-group-item list-group-item-action" href="#">
                                <div class="media mt-0">
                                    <img class="avatar-lg rounded-circle ml-3 my-auto"
                                        src="{{ URL::asset($item->image) }}" alt="Image description">
                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            <div class="mt-0">
                                                <h5 class="mb-1 tx-15">{{ $item->name_ar }}</h5>
                                                <p class="mb-0 tx-13 text-muted"> معرف المنتج : {{ $item->id }}<span
                                                        class="text-success ml-2"> عدد المشاهدات :
                                                        {{ $item->views }}</span>
                                                </p>
                                            </div>
                                            <span class="mr-auto wd-45p fs-16 mt-2">

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-10 col-lg-5">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">النشطات في التطبيق</h3>

                </div>
                <div class="product-timeline card-body pt-2 mt-1">
                    <ul class="timeline-1 mb-0">
                        <li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">عدد المنتجات </span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $totalProduct }} مجموع المنتجات </p>
                        </li>


                        <li class="mt-0"> <i
                                class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">عدد المنتجات نشطه</span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $productActive }} المنتجات نشطه</p>
                        </li>

                        <li class="mt-0"> <i
                                class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">عدد المنتجات الغير نشطه</span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $productUnActive }} المنتجات الغير نشطه</p>
                        </li>

                        <li class="mt-0"> <i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i>
                            <span class="font-weight-semibold mb-4 tx-14 ">عدد الاقسام</span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $totalCatogeries }} عدد الاقسام</p>
                        </li>
                        <li class="mt-0"> <i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span
                                class="font-weight-semibold mb-4 tx-14 ">عدد الاقسام الفرعيه</span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $totalSubCatogeries }} عدد الاقسام الفرعيه</p>
                        </li>

                        <li class="mt-0 mb-0"> <i class="icon-note icons bg-primary-gradient text-white product-icon"></i>
                            <span class="font-weight-semibold mb-4 tx-14 ">عدد الدول </span> <a href="#"
                                class="float-left tx-11 text-muted"></a>
                            <p class="mb-0 text-muted tx-12">{{ $totalcountery }} عدد الدول</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- row close -->

    <!-- row opened -->
    <div class="row row-sm row-deck">

        <div class="col-md-12 col-lg-8 col-xl-8">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">تفاصيل اخر الطلبيات</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">معرف الطلبيه</th>
                                <th class="wd-lg-25p tx-right">المبلغ الاجمالي</th>
                                <th class="wd-lg-25p tx-right">حالة الطلب</th>
                                <th class="wd-lg-25p tx-right">العميل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lastFiveOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $order->total }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ statusPayment($order->payment_status) }}
                                    </td>
                                    <td class="tx-right tx-medium tx-danger">{{ $order->user->name }}</td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
