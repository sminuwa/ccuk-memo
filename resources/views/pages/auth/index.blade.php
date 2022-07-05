<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CAPITAL CITY UNIVERSITY, KANO</title>
    <link rel="icon" type="image/x-icon" href="{{ myAsset('master/assets/img/favicon.ico') }}"/>
    <!-- Common Styles Starts -->
    <link href="{{ myAsset('master/assets/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ myAsset('master/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/structure.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/plugins/highlight/styles/monokai-sublime.css') }}" rel="stylesheet" type="text/css" />
    <!-- Common Styles Ends -->
    <!-- Common Icon Starts -->
{{--    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">--}}
    <!-- Common Icon Ends -->
    <!-- Page Level Plugin/Style Starts -->
{{--    <link href="{{ myAsset('master/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />--}}
    <link href="{{ myAsset('master/assets/css/authentication/auth_3.css') }}" rel="stylesheet" type="text/css">
    <!-- Page Level Plugin/Style Ends -->
</head>
<body class="login-three">
<!-- Loader Starts -->

<!--  Loader Ends -->
<!-- Main Body Starts -->
<div class="container-fluid login-three-container">
    <div class="row main-login-three">
        <div class="col-xl-3 col-lg-3 col-md-2 d-none d-md-block p-0">
            <div class="login-bg"></div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4">
            <div class="d-flex flex-column justify-content-between h-100 center-area">
                <a></a>
                <div>

                    @if($errors->has('message'))
                        <p class="text-danger">
                            {{ $errors->first('message') }}
                        </p>
                    @else
                        <p class="text-dark">Welcome Back</p>
                    @endif
                    <h1 class="text-black">Login to your memo app</h1>
                </div>
                <p class="text-dark d-none d-md-block m-0">Copyright @ {{ date('Y') }}</p>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-6">
            <div class="d-flex flex-column justify-content-between h-100 right-area">
                <div class="  text-white ml-auto">
                    <h3 class="header">CAPITAL CITY UNIVERSITY, KANO.</h3>
                </div>
                <div>
                    <form action="{{ route("auth.login.post") }}" method="post">
                        @csrf
                        <div class="login-three-inputs mt-5">
                            <input type="text" placeholder="Username" name="username" id="mail" required>
                            <i class="las la-user-alt"></i>
                        </div>
                        <div class="login-three-inputs mt-3">
                            <input type="password" placeholder="Password" name="password" id="password" required>
                            <i class="las la-lock"></i>
                        </div>
                        <div class="login-three-inputs check mt-4">
                            <input class="inp-cbx" id="cbx" type="checkbox" style="display: none">
                            <label class="cbx" for="cbx">
                                    <span>
                                        <svg width="12px" height="10px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                <span class="font-13 text-muted">Remember me ?</span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="text-white btn bg-gradient-primary">Login <i class="las la-key ml-2"></i></button>
{{--                            <a class="font-13 text-primary" href="auth_forget_password_3.html">Forgot your Password ?</a>--}}
                        </div>
                    </form>
                </div>
                <div class="login-three-social social-logins mt-4"></div>
            </div>
        </div>
    </div>
</div>
<!-- Main Body Ends -->
<!-- Page Level Plugin/Script Starts -->
{{--<script src="{{ myAsset('master/assets/js/loader.js') }}"></script>--}}
<script src="{{ myAsset('master/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ myAsset('master/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ myAsset('master/assets/js/authentication/auth_2.js') }}"></script>
<!-- Page Level Plugin/Script Ends -->
</body>
</html>





