@extends('layouts.master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    صفحة المستخدمين
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    جميع المستخدمين</span>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="button-container">

                        <a class="modal-effect btn btn-outline-primary mr-2" style="width: 300px;"
                            data-effect="effect-scale" data-toggle="modal" href="#exampleModal">اضافة مستخدم</a>


                        <a class="modal-effect btn btn-outline-primary mr-2" style="width: 300px;"
                            data-effect="effect-scale" data-toggle="modal" href="#exampleModal0">ارسال اشعار لجميع
                            المستخدمين</a>
                    </div>
                </div>



                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المستخدم</th>
                                    <th class="border-bottom-0">رقم الهاتف</th>
                                    <th class="border-bottom-0">البريد الاكتروني</th>
                                    <th class="border-bottom-0">المحفظه</th>
                                    <th class="border-bottom-0">صلاحيات المستخدم</th>
                                    {{-- @if ($user->hasRole('vendor'))
                                        <th class="border-bottom-0">نوع الاشتراك</th>
                                    @endif --}}
                                    <th class="border-bottom-0">حالة المستخدم</th>
                                    {{-- <th class="border-bottom-0">الدفع عند الاسلام</th> --}}
                                    <th class="border-bottom-0"> العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($userdata as $user)
                                    @php
                                        $user = \App\Models\User::find($user->id);
                                    @endphp
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone ?? 0 }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->refund }}</td>
                                        <td>{{ roleToArabic($user->roles[0]['name']) }}</td>
                                        {{-- @if ($user->hasRole('vendor'))
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-secondary" data-toggle="dropdown"
                                                        type="button">
                                                        {{ subScribeStatus($user->subscription) }}
                                                        <i class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">

                                                        <form id="language-form" action="{{ route('user.chargeSubsc') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" id="id"
                                                                value="{{ $user->id }}">
                                                            <button class="dropdown-item" type="submit"
                                                                name="subscription" value="silver">فضي
                                                            </button>
                                                            <button class="dropdown-item" type="submit"
                                                                name="subscription" value="normal">العادي
                                                            </button>
                                                            <button class="dropdown-item" type="submit"
                                                                name="subscription" value="golden">الذهبي
                                                            </button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif --}}


                                        <td>
                                            <div class="main-toggle main-toggle-success {{ $user->status == 1 ? 'on' : '' }} btn-sm ml-2"
                                                data-user-id="{{ $user->id }}" id="main-toggle">
                                                <span></span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="main-toggle main-toggle-success {{ $user->cash_on_delivery == 1 ? 'on' : '' }} btn-sm ml-2"
                                                data-user-id="{{ $user->id }}" id="cash_on_delivery">
                                                <span></span>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="d-flex">



                                                @if ($user->hasRole('vendor'))
                                                    <form action="{{ route('setting') }}">
                                                        <input type="text" name="user_id" value="{{ $user->id }}"
                                                            hidden>
                                                        <button class="btn btn-outline-primary btn-sm ml-2">الشركه

                                                        </button>
                                                    </form>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-secondary" data-toggle="dropdown"
                                                            type="button">
                                                            {{ subScribeStatus($user->subscription) }}
                                                            <i class="fas fa-caret-down ml-1"></i></button>
                                                        <div class="dropdown-menu tx-13">

                                                            <form id="language-form"
                                                                action="{{ route('user.chargeSubsc') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" id="id"
                                                                    value="{{ $user->id }}">
                                                                <button class="dropdown-item" type="submit"
                                                                    name="subscription" value="silver">فضي
                                                                </button>
                                                                <button class="dropdown-item" type="submit"
                                                                    name="subscription" value="normal">العادي
                                                                </button>
                                                                <button class="dropdown-item" type="submit"
                                                                    name="subscription" value="golden">الذهبي
                                                                </button>

                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif

                                                <button class="btn btn-outline-danger btn-sm mr-2"
                                                    data-pro_id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-toggle="modal" data-target="#exampleModal00">ارسال اشعار
                                                </button>

                                                <button class="btn btn-outline-danger btn-sm mr-2"
                                                    data-pro_id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-toggle="modal" data-target="#exampleModal000">شحن المحفظه
                                                </button>

                                                <form action="{{ route('userUpdate', $user->id) }}">
                                                    <button class="btn btn-outline-success btn-sm mr-2">تعديل

                                                    </button>
                                                </form>

                                                <button class="btn btn-outline-danger btn-sm mr-2"
                                                    data-pro_id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-toggle="modal" data-target="#modaldemo9">حذف</button>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المستخدم</th>
                                    <th class="border-bottom-0">المبلغ</th>
                                    <th class="border-bottom-0">التاريخ</th>
                                    <th class="border-bottom-0">المحفظه</th>
                                    {{-- <th class="border-bottom-0">المحفظه</th> --}}
                                    {{-- <th class="border-bottom-0"> العمليات</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($histories as $historie)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $historie->user->name }}</td>
                                        <td>{{ $historie->money ?? 0 }}</td>
                                        <td>{{ $historie->created_at ?? 0 }}</td>
                                        <td>{{ $historie->user->refund }}</td>
                                        {{-- <td>{{ $historie->user->refund }}</td> --}}


                                        {{-- <td>
                                            <div class="d-flex">
                                                <button class="btn btn-outline-danger btn-sm mr-2"
                                                    data-pro_id="{{ $historie->id }}" data-name="{{ $historie->name }}"
                                                    data-toggle="modal" data-target="#modaldemo9">حذف</button>
                                            </div>
                                        </td> --}}

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php
                $url = url()->current();
                $parts = explode('/', $url);
                $lastWord = end($parts);
            @endphp
            @if ($lastWord == 'affiliate')
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example32" class="table key-buttons text-md-nowrap" data-page-length='50'>
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">اسم المسوق بالعموله</th>
                                        <th class="border-bottom-0">المبلغ</th>
                                        <th class="border-bottom-0">التاريخ</th>
                                        <th class="border-bottom-0">المحفظه</th>
                                        <th class="border-bottom-0">رقم الطلب</th>
                                        <th class="border-bottom-0"> العمليات</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($marketers as $historie)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $historie->user->name }}</td>
                                            <td>{{ $historie->money ?? 0 }}</td>
                                            <td>{{ $historie->created_at ?? 0 }}</td>
                                            <td>{{ $historie->user->refund }}</td>
                                            <td>{{ $historie->order_id }}</td>
                                            <td>

                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-secondary" data-toggle="dropdown"
                                                        type="button">{{ typeStatusAfallite($historie->status) }}<i
                                                            class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">

                                                        <form id="language-form"
                                                            action="{{ route('user.userAffaliteUpadeType') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $historie->id }}">

                                                            <button class="dropdown-item" type="submit" name="status"
                                                                value="return">مرتجع</button>
                                                            <button class="dropdown-item" type="submit" name="status"
                                                                value="sold">تم البيع</button>
                                                            <button class="dropdown-item" type="submit" name="status"
                                                                value="charge">تم التحويل للمحفظه</button>
                                                            <button class="dropdown-item" type="submit" name="status"
                                                                value="procedure">تحت الاجراء</button>
                                                        </form>
                                                    </div>
                                                </div>




                                            </td>


                                            {{-- <td>
                                            <div class="d-flex">
                                                <button class="btn btn-outline-danger btn-sm mr-2"
                                                    data-pro_id="{{ $historie->id }}" data-name="{{ $historie->name }}"
                                                    data-toggle="modal" data-target="#modaldemo9">حذف</button>
                                            </div>
                                        </td> --}}

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endif






            <!-- not -->
            <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ارسال اشعار للمستخدمين</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('send.notificationToAll') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">العنوان</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">الرساله</label>
                                    <input type="text" class="form-control" id="message" name="message" required>
                                </div>
                                <input type="text" class="form-control" id="type" name="type" value="all"
                                    hidden>

                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>


            <!-- not user -->
            <div class="modal fade" id="exampleModal00" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ارسال اشعار للمستخدمين</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('send.notification') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم الالمستخدم</label>
                                    <input type="text" class="form-control" id="name" name="name" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">العنوان</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">الرساله</label>
                                    <input type="text" class="form-control" id="message" name="message" required>
                                </div>

                                <input type="text" class="form-control" id="user_id" name="user_id" value=""
                                    hidden>
                                <input type="text" class="form-control" id="type" name="type" value="one"
                                    hidden>


                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal000" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h5 class="modal-title" id="exampleModalLabel">ارسال اشعار للمستخدمين</h5> --}}
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('user.chargeWallet') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم الالمستخدم</label>
                                    <input type="text" class="form-control" id="name" name="name" readonly>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">قيمة المبلغ</label>
                                    <input type="text" class="form-control" id="money" name="money" required>
                                </div>

                                <input type="text" class="form-control" id="user_id" name="user_id" value=""
                                    hidden>
                                <input type="text" class="form-control" id="type" name="type" value="one"
                                    hidden>


                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
            <!-- add -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">اضافة المستخدم</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('user.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم الالمستخدم</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>


                                <div class="form-group">
                                    <label for="title">رقم الهاتف </label>
                                    <input type="number" class="form-control" name="phone" id="mmmmm">
                                </div>
                                <div class="mb-4">
                                    <p class="mg-b-10">صلاحيات المستخدمين</p>
                                    <select name="roles[]" multiple="multiple" class="testselect2" required>
                                        @foreach ($roles as $role)
                                            <option title="{{ $role->name }}" value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">البريد الاكتروني </label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">كلمة السر</label>
                                    <input type="password" class="form-control" name="password" id="password" required
                                        min="8">
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>

                        </form>


                    </div>
                </div>
            </div>

            <!-- edit -->
            <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">تعديل المستخدم</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action='{{ route('user.update') }}' method="post">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">اسم المستخدم :</label>
                                    <input type="hidden" class="form-control" name="pro_id" id="pro_id"
                                        value="">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="title">رقم الهاتف</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        value="">
                                </div>
                                <div class="mb-4">
                                    <p class="mg-b-10">صلاحيات المستخدمين</p>
                                    <select name="roles[]" multiple="multiple" class="testselect2">
                                        @foreach ($roles as $role)
                                            <option title="{{ $role->name }}" value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">البريد الإلكتروني</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">كلمة السر (اتركها فارغة إذا لم ترغب بتغييرها)</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">حذف الالمستخدم</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="user.destroy" method="post">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="pro_id" id="pro_id" value="">
                                <input class="form-control" name="name" id="name" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#cash_on_delivery').on('click', function() {
                $(this).toggleClass('on');
                var isToggleOn = $(this).hasClass('on');
                var url = '{{ route('user.cash_on_delivery') }}';
                var userId = $(this).data('user-id');
                // Retrieve the CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        isToggleOn: isToggleOn,
                        userId: userId
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle the success response
                    },
                    error: function(error) {
                        console.log(error);
                        // Handle the error response
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#main-toggle').on('click', function() {
                $(this).toggleClass('on');
                var isToggleOn = $(this).hasClass('on');
                var url = '{{ route('userCreate') }}';
                var userId = $(this).data('user-id');
                // Retrieve the CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        isToggleOn: isToggleOn,
                        userId: userId
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle the success response
                    },
                    error: function(error) {
                        console.log(error);
                        // Handle the error response
                    }
                });
            });
        });
        $('#exampleModal000').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var name = button.data('name')
            var modal = $(this)

            modal.find('.modal-body #user_id').val(pro_id);
            modal.find('.modal-body #name').val(name);
        })
        $('#exampleModal00').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var name = button.data('name')
            var modal = $(this)

            modal.find('.modal-body #user_id').val(pro_id);
            modal.find('.modal-body #name').val(name);
        })
    </script>

    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!-- Internal TelephoneInput js-->
    <script src="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>
    <!-- Internal Data tables -->
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
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#edit_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var name = button.data('name')
            var pro_id = button.data('pro_id')
            var phone = button.data('phone')
            var email = button.data('email')
            // var password = button.data('password')

            var modal = $(this)
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #phone').val(phone);
            // modal.find('.modal-body #password').val(password);
        })


        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var name = button.data('name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #name').val(name);
        })
    </script>

@endsection
