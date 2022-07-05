<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        <ul class="navbar-item flex-row ml-md-0 ml-auto theme-brand">
            <li class="nav-item align-self-center d-md-none">
                <div class="d-flex flex-row align-center justify-content-center logo-area">
                    <a href="index.html" class="nav-link pr-0 pl-1">
                        <img src="{{ myAsset('master/assets/img/logo.jpg') }}" class="navbar-logo" alt="logo">
                    </a>
                    {{--                            <a href="index.html" class="nav-link pr-4 d-none d-md-block"> Xato </a>--}}
                </div>
            </li>
            <li class="nav-item align-self-center search-animated">
                <i class="las la-search toggle-search"></i>
                <form class="form-inline search-full form-inline search" action="pages_search_result.html" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search here">
                    </div>
                </form>
            </li>
            <li class="nav-item dropdown megamenu-dropdown d-none d-lg-flex">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle d-flex align-center text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mega Menu  <i class="las la-angle-down font-11 ml-1"></i>
                </a>
                <div class="dropdown-menu megamenu">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="font-17 mt-0">Applications</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li class="font-15 mb-1"><a href="apps_ecommerce.html">Ecommerce</a></li>
                                        <li class="font-15 mb-1"><a href="apps_chat.html">Chat</a></li>
                                        <li class="font-15 mb-1"><a href="apps_mail.html">Email</a></li>
                                        <li class="font-15 mb-1"><a href="apps_file_manager.html">File Manager</a></li>
                                        <li class="font-15 mb-1"><a href="apps_calendar.html">Calender</a></li>
                                        <li class="font-15 mb-1"><a href="apps_notes.html">Notes</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-17 mt-0">Extra Pages</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li class="font-15 mb-1"><a href="pages_contact_us.html">Contact Us</a></li>
                                        <li class="font-15 mb-1"><a href="pages_faq.html">FAQ</a></li>
                                        <li class="font-15 mb-1"><a href="pages_helpdesk.html">Helpdesk</a></li>
                                        <li class="font-15 mb-1"><a href="pages_pricing_2.html">Pricing</a></li>
                                        <li class="font-15 mb-1"><a href="pages_search_result.html">Search Result</a></li>
                                        <li class="font-15 mb-1"><a href="pages_privacy_policy.html">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-item flex-row ml-md-auto">
            <li class="nav-item dropdown fullscreen-dropdown d-none d-lg-flex">
                <a class="nav-link full-screen-mode" href="javascript:void(0);">
                    <i class="las la-compress" id="fullScreenIcon"></i>
                </a>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="{{ myAsset('master/assets/img/profile-16.jpg') }}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="nav-drop is-account-dropdown" >
                        <div class="inner">
                            <div class="nav-drop-header">
                                <span class="text-primary font-15">Welcome Admin !</span>
                            </div>
                            <div class="nav-drop-body account-items pb-0">
                                <a id="profile-link"  class="account-item" href="pages_profile.html">
                                    <div class="media align-center">
                                        <div class="media-left">
                                            <div class="image">
                                                <img class="rounded-circle avatar-xs" src="{{ myAsset('master/assets/img/profile-16.jpg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong">Sara</h6>
                                            <small>Britannia</small>
                                        </div>
                                        <div class="media-right">
                                            <i data-feather="check"></i>
                                        </div>
                                    </div>
                                </a>
                                <a class="account-item" href="pages_profile.html">
                                    <div class="media align-center">
                                        <div class="icon-wrap">
                                            <i class="las la-user font-20"></i>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong">My Account</h6>
                                        </div>
                                    </div>
                                </a>
                                <a class="account-item" href="pages_timeline.html">
                                    <div class="media align-center">
                                        <div class="icon-wrap">
                                            <i class="las la-briefcase font-20"></i>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong">My Activity</h6>
                                        </div>
                                    </div>
                                </a>
                                <a class="account-item settings">
                                    <div class="media align-center">
                                        <div class="icon-wrap">
                                            <i class="las la-cog font-20"></i>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong">Settings</h6>
                                        </div>
                                    </div>
                                </a>
                                <a class="account-item" href="auth_lock_screen_3.html">
                                    <div class="media align-center">
                                        <div class="icon-wrap">
                                            <i class="las la-lock font-20"></i>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong">Lock Screen</h6>
                                        </div>
                                    </div>
                                </a>
                                <hr class="account-divider">
                                <a class="account-item" href="auth_login_3.html">
                                    <div class="media align-center">
                                        <div class="icon-wrap">
                                            <i class="las la-sign-out-alt font-20"></i>
                                        </div>
                                        <div class="media-content ml-3">
                                            <h6 class="font-13 mb-0 strong ">Logout</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="navbar-item flex-row">
            <li class="nav-item dropdown header-setting">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle rightbarCollapse" data-placement="bottom">
                    <i class="las la-sliders-h"></i>
                </a>
            </li>
        </ul>
    </header>
</div>
