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
                            <h1 class="invoice-title">Invoice</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>name : {{ $order->user->name }}</h6><br>

                                    Country : {{ $order->userAddress->country }}<br>
                                    City: {{ $order->userAddress->city }}<br>

                                    The first address : {{ $order->userAddress->address_1 }}<br>
                                    @if ($order->userAddress->address_2)
                                        The second address : {{ $order->userAddress->address_2 }}<br>
                                    @endif
                                    phone number : {{ $order->userAddress->phone }}<br>
                                    Email: {{ $order->userAddress->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">Invoice Information</label>
                                <p class="invoice-info-row"><span>Invoice No</span> <span>{{ $order->id }}</span></p>
                                {{-- <p class="invoice-info-row"><span>Project ID</span> <span>32334300</span></p> --}}
                                <p class="invoice-info-row"><span>Issue Date:</span>
                                    <span>{{ now()->format('F d, Y') }}</span>
                                </p>
                                {{-- <p class="invoice-info-row"><span>Due Date:</span> <span>November 30, 2017</span></p> --}}
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">Product name</th>
                                        <th class="wd-25p">Description</th>
                                        <th class="tx-center">QNTY</th>
                                        <th class="tx-right">Unit Price</th>
                                        <th class="tx-right">Discount</th>
                                        <th class="tx-right">shipping fee </th>
                                        {{-- <th class="tx-right">Amount</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name_en }}</td>
                                            <td class="tx-3">{{ Str::limit($item->product->description_en, 80, '...') }}
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
                                                <label class="main-content-label tx-13">Notes</label>
                                                <p class="p-black">{{ $order->description }}</p>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">Sub-Total</td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">shipping fee </td>
                                        <td class="tx-right" colspan="2">{{ number_format($order->shipping, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">Discount</td>
                                        <td class="tx-right" colspan="2">-{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
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
                                class="mdi mdi-printer ml-1"></i>Print</button>
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
