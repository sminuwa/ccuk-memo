<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CAPITAL CITY UNIVERSITY, KANO </title>
    <link rel="icon" type="image/x-icon" href="{{ myAsset('logo.jpg') }}"/>
    @include('commons.master.styles')
</head>
<body class="">
<!-- Loader Starts -->
<div id="load_screen">
    <div class="bars-two">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!--  Loader Ends -->
<!--  Main Container Starts  -->
<div class="main-container sidebar-closed" id="container">
    <!-- Logo area (Larger Screen) Starts -->
    <div class="tl-logo-area d-none d-md-block">
        <div class="d-flex flex-row align-center justify-content-center logo-area">
            <a href="index.html" class="nav-link pr-0 pl-0">
                <img src="{{ myAsset('master/assets/img/logo.jpg') }}" class="navbar-logo" alt="logo">
            </a>
{{--            <a href="index.html" class="nav-link d-none d-md-block"> Xato </a>--}}
        </div>
    </div>
    <!-- Logo area (Larger Screen) Ends -->
    <div class="overlay"></div>
    <div class="search-overlay"></div>
    <div class="rightbar-overlay"></div>
    <!--  Sidebar Starts  -->
    @include('commons.master.sidebar')
    <!--  Sidebar Ends  -->
    <!--  Content Area Starts  -->
    <div id="content" class="main-content">
        <!--  Navbar Starts  -->
        @include('commons.master.topbar')
        <!--  Navbar Ends  -->
        <!--  Navbar Starts / Breadcrumb Area  -->
        <div class="sub-header-container">
            <header class="header navbar navbar-expand-sm">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                    <i class="las la-bars"></i>
                </a>
                <ul class="navbar-nav flex-row">
                    <li>
                        <div class="page-header">
                            <nav class="breadcrumb-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @for($i = 0; $i <= count(array_filter(Request::segments())); $i++)
                                        @if($i < count(Request::segments()) & $i > 0)
                                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{Request::segment($i)}}</a></li>
                                        @else
                                            <li class="breadcrumb-item active" aria-current="page"><span>{{Request::segment($i)}}</span></li>
                                        @endif
                                    @endfor
                                </ol>
                            </nav>
                        </div>
                    </li>
                </ul>
            </header>
        </div>
        <!--  Navbar Ends / Breadcrumb Area  -->
        <!-- Main Body Starts -->
        <div class="layout-px-spacing">
            <div class="layout-top-spacing mb-2">
                @yield('content')
            </div>
        </div>
        <!-- Main Body Ends -->
        @include('commons.master.device-view-change')
        <!-- Copyright Footer Starts -->
        @include('commons.master.footer')
        <!-- Copyright Footer Ends -->
        <!-- Arrow Starts -->
        <div class="scroll-top-arrow" style="display: none;">
            <i class="las la-angle-up"></i>
        </div>
        <!-- Arrow Ends -->
    </div>
    <!--  Content Area Ends  -->
    <!--  Rightbar Area Starts -->
    @include('commons.master.rightbar')
    <!--  Rightbar Area Ends -->
    @yield('modals')
</div>
<!-- Main Container Ends -->
@include('commons.master.scripts')
</body>
</html>
