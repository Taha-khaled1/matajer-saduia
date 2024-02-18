@extends('layouts.master')
@section('css')
    <style>
        .p-black {
            color: black !important;

        }

        @media print {
            #print_Button {
                display: none;
            }
        }


        .p-black:hover {
            color: blue !important;
        }

        .invoice-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Invoice</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <div class=""> <img class="invoice-image" src="{{ asset($setting->logo) }}"
                                    alt="Invoice"> </div>
                            <div class="billed-from">
                                <h6>معلومات الشركه للاستفسار</h6>
                                <p> العنوان: {{ $setting->company_address }}<br>
                                    رقم الهاتف: {{ $setting->company_phone }}<br>
                                    البريد: {{ $setting->email }}</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">عنوان المستخدم</label>
                                <div class="billed-to">
                                    <h6>الاسم : {{ $order->user->name }}</h6><br>

                                    الدوله : {{ $order->userAddress->country }}<br>
                                    المدينه: {{ $order->userAddress->city }}<br>

                                    العنوان الاول : {{ $order->userAddress->address_1 }}<br>
                                    @if ($order->userAddress->address_2)
                                        العنوان الثاني : {{ $order->userAddress->address_2 }}<br>
                                    @endif
                                    رقم الهاتف : {{ $order->userAddress->phone }}<br>
                                    البريد : {{ $order->userAddress->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">معلومات الفاتورة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{ $order->id }}</span></p>
                                {{-- <p class="invoice-info-row"><span>Project ID</span> <span>32334300</span></p> --}}
                                <p class="invoice-info-row"><span>تاريخ الاصدار:</span>
                                    <span>{{ now()->format('F d, Y') }}</span>
                                </p>
                                {{-- <p class="invoice-info-row"><span>Due Date:</span> <span>November 30, 2017</span></p> --}}
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">اسم المنتج</th>
                                        <th class="wd-25p">الوصف</th>
                                        <th class="tx-center">العدد</th>
                                        <th class="tx-right">السعر الرئيسي</th>
                                        <th class="tx-right">الخصم</th>
                                        <th class="tx-right">ضريبة المنتج</th>
                                        {{-- <th class="tx-right">Amount</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name_ar }}</td>
                                            <td class="tx-3">{{ Str::limit($item->product->description_ar, 80, '...') }}
                                            </td>
                                            <td class="tx-center">{{ $item->quantity }}</td>
                                            <td class="tx-right">{{ $item->product->price }}</td>
                                            <td class="tx-right">{{ $item->product->discount }}</td>
                                            <td class="tx-right">{{ $item->product->shipping_fee }}</td>
                                            {{-- <td class="tx-right">$300.00</td> --}}
                                        </tr>
                                    @endforeach




                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">ملاحظه</label>
                                                <p class="p-black">{{ $order->description }}</p>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">الإجمالي الفرعي</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">ضريبه</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->shipping, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">الإجمالي االخصم</td>
                                        <td class="tx-right" colspan="2">-{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">المبلغ الإجمالي</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">{{ number_format($order->total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        {{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
                            <i class="mdi mdi-currency-usd ml-1"></i>Pay Now
                        </a> --}}

                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>طباعه</button>
                        {{-- <a href="#" class="btn btn-danger float-left mt-3 mr-2">
                            <i class="mdi mdi-printer ml-1"></i>Print
                        </a> --}}


                        {{-- <a href="#" class="btn btn-success float-left mt-3">
                            <i class="mdi mdi-telegram ml-1"></i>Send Invoice
                        </a> --}}
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
