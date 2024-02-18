@extends('layouts.master')


@section('css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@section('title')
    الدول
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الاعدادات /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">الدول و
                الضرائب
            </span>
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

@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<!-- row -->
<div class="row">

    <div class="col-xl-12">
        <div class="card">
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                    href="#modaldemo8">اضافة دوله</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم الدوله</th>
                                <th class="wd-15p border-bottom-0">الضريبه لكل كيلو</th>

                                <th class="wd-20p border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $i = 0;
                            @endphp

                            @foreach ($countries as $country)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    </td>
                                    <td>{{ $country->name }}</td>
                                    <td>{{ $country->country_tax }}</td>
                                    <td>

                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                            data-id="{{ $country->id }}" data-name="{{ $country->name }}"
                                            data-name_en="{{ $country->name_en }}"
                                            data-country_tax="{{ $country->country_tax }}" data-toggle="modal"
                                            href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>



                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $country->id }}" data-name="{{ $country->name }}"
                                            data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                class="las la-trash"></i></a>

                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة دوله</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('countries.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">اسم الدوله</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div> --}}

                        {{-- <input type="text" id="search" placeholder="Search for countries...">

                        <select id="countries" size="10" multiple>
                            @foreach ($countries as $country)
                                <option class="country" value="{{ $country['iso_3166_1_alpha2'] }}">
                                    {{ $country['name'] }}</option>
                            @endforeach
                        </select> --}}
                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <div class="form-group">
                            <strong>اسم الدوله بالعربيه</strong>
                            <select name="name" id="country" class="form-control mb-1">
                                <option value="">اسم الدوله بالعربيه</option>
                                @foreach ($countriesListar as $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- </div> --}}

                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <div class="form-group">
                            <strong>اسم الدوله بالانجليزيه</strong>
                            <select name="name_en" id="countries" class="form-control mb-1">
                                <option value="">اسم الدوله بالانجليزيه</option>
                                @foreach ($countriesListen as $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- </div> --}}
                        <input type="text" id="latitude" name="latitude" value="" hidden>
                        <input type="text" id="longitude" name="longitude" value="" hidden>

                        <div class="form-group">
                            <label for="exampleInputEmail1">الضريبه لكل كيلو</label>
                            <input type="number" class="form-control" id="country_tax" name="country_tax" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل الدوله</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('countries.update') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="">
                        {{-- <div class="form-group">
                            <label for="recipient-name" class="col-form-label">اسم الدوله</label>
                            <input class="form-control" name="name" id="name" type="text" required>
                        </div> --}}



                        <div class="form-group">
                            <strong>اسم الدوله بالعربيه</strong>
                            <select name="name" id="country_ar" class="form-control mb-1">
                                {{-- <option value="">اسم الدوله بالعربيه</option> --}}
                                @foreach ($countriesListar as $country)
                                    {{-- {{ $country == $category->id ? 'selected' : '' }}    --}}
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- </div> --}}

                        {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
                        <div class="form-group">
                            <strong>اسم الدوله بالانجليزيه</strong>
                            <select name="name_en" id="country_en" class="form-control mb-1">
                                <option value="">اسم الدوله بالانجليزيه</option>
                                @foreach ($countriesListen as $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>




                        <div class="form-group">
                            <label for="exampleInputEmail1">الضريبه لكل كيلو</label>
                            <input type="number" class="form-control" id="country_tax" name="country_tax" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف الدوله</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('countries.destroy') }}"method="post">
                    {{ method_field('post') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

</div>
<!-- Container closed -->


@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var name_en = button.data('name_en')
            var country_tax = button.data('country_tax')
            var modal = $(this)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #name').val(name)
            modal.find('.modal-body #name_en').val(name_en)
            modal.find('.modal-body #country_tax').val(country_tax);
        })
    });
</script>
<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var country_tax = button.data('country_tax')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #country_tax').val(country_tax);
    })
</script>





<script src="{{ asset('js/select2.min.js') }}"></script>

<script>
    $('#search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#countries .country").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $('#countries').change(function() {
        var country = $(this).val(); // selected country

        $.ajax({
            url: 'https://restcountries.com/v2/name/' + country,
            method: 'GET',
            success: function(data) {
                var lat = data[0].latlng[0];
                var lng = data[0].latlng[1];
                console.log('Latitude: ' + lat + ', Longitude: ' + lng);

                $('#latitude').val(lat);
                $('#longitude').val(lng);
            },
            error: function() {
                console.log('Error retrieving data');
            }
        });
    });
</script>

<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>




@endsection
