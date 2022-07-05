
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ myAsset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ myAsset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        E-MEMO
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="{{ myAsset('assets/DataTables/datatables.min.css') }}"/>
    <!-- CSS Files -->
    @include('commons.style')
    <style>
        a, a:hover, a:focus, a:active {
            text-decoration: none;
            color: inherit;
        }
        a:hover{
            background: #f8f8f8 !important;
        }
        a:focus{
            background: #f0f0f0 !important;
        }
    </style>
    @yield('css')
    @livewireStyles
</head>

<body class="">

<div class="wrapper" @auth() @else style="background: #f4f3ef;" @endauth>
    <div class="main-panel" style="width:100%">
        <!-- Navbar -->
{{--    @include('commons.navbar')--}}
    <!-- End Navbar -->
        <div class="content">
            @php $user = auth()->user(); @endphp
            <div class="row text-center">
                <div class="col-lg-12">
                    {{--<h3>CAPITAL CITY UNIVERSITY, KANO.</h3>--}}
                    <h4 align="center"><strong style="font-weight: bolder">CAPITAL CITY UNIVERSITY, KANO</strong> <br>
                        <small>No. 20 Yusuf Maitama Sule Road, Nassarawa GRA, Kano - Nigeria</small>
                    </h4>
                    <h4 align="center"><span style="background: black; color:white;"> &nbsp;&nbsp; MENUS &nbsp;&nbsp; </span></h4>
                    <div style="height:30px;"></div>
                </div>
                <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <a href="{{ route('memos.index') }}" class="p-lg-2">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5 col-md-4">
                                                <div class="icon-big text-center icon-warning">
                                                    <i class="nc-icon nc-email-85 text-info"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 col-md-8">
                                                <div class="numbers">
                                                    <p class="card-category text-info">Internal Memos</p>
                                                    <p class="card-title">0 <small style="font-size: 10px">Memos</small><p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <a href="{{ route('forms.dashboard') }}" class="p-lg-2">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5 col-md-4">
                                                <div class="icon-big text-center icon-warning">
                                                    <i class="nc-icon nc-single-copy-04 text-success"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 col-md-8">
                                                <div class="numbers">
                                                    <p class="card-category text-success">Forms</p>
                                                    <p class="card-title">0 <small style="font-size: 10px">Forms</small><p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <a href="" class="p-lg-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 col-md-4">
                                                <div class="icon-big text-center icon-warning">
                                                    <i class="nc-icon nc-money-coins text-warning"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 col-md-8">
                                                <div class="numbers">
                                                    <p class="card-category text-warning">Payroll</p>
                                                    <p class="card-title">0 <small style="font-size: 10px">PaySlip</small><p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <a href="" class="p-lg-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5 col-md-4">
                                                <div class="icon-big text-center icon-warning">
                                                    <i class="nc-icon nc-single-02 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 col-md-8">
                                                <div class="numbers">
                                                    <p class="card-category text-primary">Human Resources</p>
                                                    <p class="card-title">0 <small style="font-size: 10px">Staff</small><p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('commons.footer')
    </div>
</div>
<!--   Core JS Files   -->

<script src="{{ myAsset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ myAsset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ myAsset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ myAsset('assets/js/paper-dashboard.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/datatables.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/bootstrap-select.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script type="text/javascript" src="{{ myAsset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ myAsset('assets/js/select2.full.min.js') }}"></script>
@yield('js')

<script src="{{ myAsset('vendor/livewire/livewire.js?id=25f025805c3c370f7e87') }}"></script>
@livewireScripts
</body>
</html>

