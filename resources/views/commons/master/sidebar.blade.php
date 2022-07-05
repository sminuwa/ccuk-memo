@php $user = auth()->user(); $r = request(); @endphp
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="fixed-profile">
            <div class="premium-border">
                <img src="{{ myAsset('master/assets/placeholders/user.jpg') }}" class="profile-avatar"/>
            </div>
            <div class="mt-3">
                <h6 class="text-white font-14 mb-1">{{ $user->fullName() }}</h6>
                <p class="text-white font-13 mb-0">{{ $user->position()->name }}</p>
            </div>
            <ul class="flex-row profile-option-container">
                <li class="option-item dropdown message-dropdown">
                    <div class="option-link-container dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a class="option-link dropdown-toggle">
                            <i class="las la-envelope"></i>
                        </a>
                        <div class="text-left">
                            <h6>My Memos</h6>
                            <p>{{ $user->memos()->count() }} Memos</p>
                        </div>
                    </div>
                    <div class="dropdown-menu position-absolute md-container" aria-labelledby="messageDropdown">
                        <div class="nav-drop is-notification-dropdown">
                            <div class="inner">
                                <div class="nav-drop-header">
                                    <span class="text-black font-12 strong">3 new mails</span>
                                    <a class="text-muted font-12" href="#">
                                        Mark all read
                                    </a>
                                </div>
                                <div class="nav-drop-body account-items pb-0">
                                    <a class="account-item">
                                        <div class="media">
                                            <div class="user-img">
                                                <img class="rounded-circle avatar-xs" src="{{ myAsset('master/assets/img/profile-11.jpg') }}" alt="profile">
                                            </div>
                                            <div class="media-body">
                                                <div class="">
                                                    <h6 class="text-dark font-13 mb-0 strong">Jennifer Queen</h6>
                                                    <p class="m-0 mt-1 font-10 text-muted">Permission Required</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <hr class="account-divider">
                                    <div class="text-center">
                                        <a class="text-primary strong font-13" href="apps_mail.html">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="option-item dropdown notification-dropdown">
                    <a class="option-link-container" href="pages_notifications.html">
                        <div class="option-link">
                            <i class="las la-bell"></i>
                            <div class="blink">
                                <div class="circle"></div>
                            </div>
                        </div>
                        <div class="text-left">
                            <h6>Notifications</h6>
                            <p>4 Unread</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu @if($r->routeIs('dashboard*')) active @endif">
                <a href="javascript:void(0);" id="dashboard" @if($r->routeIs('dashboard*')) data-active="true" @endif class="main-item dropdown-toggle">
                    <i class="las la-campground"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu @if($r->routeIs('memos*')) active @endif">
                <a href="javascript:void(0);" id="memo" @if($r->routeIs('memos*')) data-active="true" @endif class="main-item dropdown-toggle">
                    <i class="las la-envelope"></i>
                    <span>Memos</span>
                </a>
            </li>
            @if($user->canAccess('hr.module'))
            <li class="menu @if($r->routeIs('hr*')) active @endif">
                <a href="javascript:void(0);" id="hr" @if($r->routeIs('hr*')) data-active="true" @endif class="main-item dropdown-toggle">
                    <i class="las la-user-tie"></i>
                    <span>HR</span>
                </a>
            </li>
            @endif
            @if($user->canAccess('payroll.module'))
            <li class="menu @if($r->routeIs('payroll*')) active @endif">
                <a href="javascript:void(0);" id="payroll" @if($r->routeIs('payroll*')) data-active="true" @endif class="main-item dropdown-toggle">
                    <i class="las la-handshake"></i>
                    <span>Payroll</span>
                </a>
            </li>
            @endif


        </ul>
        <div class="sidebar-submenu">
            <span class="sidebar-submenu-close" id="sidebarSubmenuClose">
                <i class="las la-times"></i>
            </span>
            <div class="submenu" id="memoMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Memo Module</h5>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="{{ route('memos.index') }}"> My Memos </a>
                        </li>
                        <li>
                            <a href="{{ route('memos.create') }}"> Create Memo </a>
                        </li>
                        @if(auth()->user()->canAccess('archived.close'))
                        <li><a href="{{ route('memos.archived') }}"> Archived Memos </a></li>
                        @endif
                        @if($user->canAccess('reports.index'))
                        <li><a href="{{ route('reports.index') }}"> Memo Report </a></li>
                        @endif
                        <li>
                            <a href="{{ route('messages.index') }}"> Custom Messages </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="vehicleMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Vehicle Module</h5>
                        <p></p>
                    </div>
                    <ul class="submenu-list" data-parent-element="#vehicle">
                        <li class="@if($r->routeIs('vehicles.index*') || $r->routeIs('vehicles.show*')) active @endif">
                            <a href="{{ route('vehicles.index') }}"> Vehicles </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.location.*')) active @endif">
                            <a href="{{ route('vehicles.location.index') }}"> Location </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.route.*')) active @endif">
                            <a href="{{ route('vehicles.route.index') }}"> Routes </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.location_route.*')) active @endif">
                            <a href="{{ route('vehicles.location_route.index') }}"> Location Route Configuration </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.fuel_price.*')) active @endif">
                            <a href="{{ route('vehicles.fuel_price.index') }}"> Fuel Configuration </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.fuel_price.*')) active @endif">
                            <a href="{{ route('vehicles.fuel_price.index') }}"> Report </a>
                        </li>
                        <li class="@if($r->routeIs('vehicles.configurations.*')) active @endif">
                            <a href="{{ route('vehicles.configurations.index') }}"> General Configurations </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="inventoryMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Inventory Module</h5>
                        <p></p>
                    </div>
                    <ul class="submenu-list">
                        <li class="@if($r->routeIs('inventory.purchases.*')) active @endif">
                            <a href="{{ route('inventory.purchases.index') }}"> Purshases </a>
                        </li>
                        <li class="@if($r->routeIs('inventory.customers.*')) active @endif">
                            <a href="{{ route('inventory.customers.index') }}"> Customers </a>
                        </li>
                        <li class="@if($r->routeIs('inventory.suppliers.*')) active @endif">
                            <a href="{{ route('inventory.suppliers.index') }}"> Suppliers </a>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#configuration" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Configurations <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('inventory.configurations*')) show @endif" id="configuration">
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> Items </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.categories*')) active @endif">
                                    <a href="{{ route('inventory.configurations.categories.index') }}"> Categories </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.units*')) active @endif">
                                    <a href="{{ route('inventory.configurations.units.index') }}"> Units </a>
                                </li>
                                <li>
                                    <a href="#"> Warehouses </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="submenu" id="hrMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">HR Module</h5>
                        <p></p>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="#"> Dashboard </a>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#staff" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Manage Staff <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('inventory.configurations*')) show @endif" id="staff">
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> Create staff </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.categories*')) active @endif">
                                    <a href="{{ route('inventory.configurations.categories.index') }}"> Staff List </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.units*')) active @endif">
                                    <a href="{{ route('inventory.configurations.units.index') }}"> Authorization </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#task" role="button" aria-expanded="@if($r->routeIs('hr.tasks*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('hr.tasks*')) active @endif">
                                Manage Tasks <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('hr.tasks*')) show @endif" id="task">
                                <li class="@if($r->routeIs('hr.tasks.index')) active @endif">
                                    <a href="{{ route('hr.tasks.index') }}"> Tasks List</a>
                                </li>
                                <li class="@if($r->routeIs('hr.tasks.mappings*')) active @endif">
                                    <a href="{{ route('hr.tasks.mappings.index') }}"> Mapping </a>
                                </li>
                                <li class="@if($r->routeIs('hr.tasks.schedules*')) active @endif">
                                    <a href="{{ route('hr.tasks.schedules.index') }}"> Schedules </a>
                                </li>
                                <li>
                                    <a href="#"> Configuration </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"> Evaluation </a>
                        </li>
                        <li>
                            <a href="#"> Reports </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="payrollMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Payroll Module</h5>
                        {{--                        <p>Our being able to do what we like best.</p>--}}
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="#">Dashboard </a>
                        </li>
                        <li class="@if($r->routeIs('payroll.payments.index*')) active @endif">
                            <a href="{{ route('payroll.payments.index') }}"> Make Payment</a>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#payroll" role="button" aria-expanded="@if($r->routeIs('payroll.salary*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('payroll.salary*')) active @endif">
                                Manage Salary <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('payroll.salary*')) show @endif" id="payroll">
                                <li class="@if($r->routeIs('payroll.salary.sheet*')) active @endif">
                                    <a href="{{ route('payroll.salary.sheet.index') }}"> Salary Sheet </a>
                                </li>
                                <li class="@if($r->routeIs('payroll.salary.bank*')) active @endif">
                                    <a href="{{ route('payroll.salary.bank.index') }}"> Bank Sheet </a>
                                </li>
                                <li class="@if($r->routeIs('payroll.salary.structure*')) active @endif">
                                    <a href="{{ route('payroll.salary.structure.index') }}"> Salary Structure </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@if($r->routeIs('payroll.allowances*')) active @endif">
                            <a href="{{ route('payroll.allowances.index') }}"> Manage Allowances </a>
                        </li>
                        <li class="@if($r->routeIs('payroll.deductions*')) active @endif">
                            <a href="{{ route('payroll.deductions.index') }}"> Manage Deductions </a>
                        </li>
                        <li class="@if($r->routeIs('payroll.staff*')) active @endif">
                            <a href="{{ route('payroll.staff.index') }}"> Staff Enrolment</a>
                        </li>

                        {{--<li class="@if($r->routeIs('payroll.payslip*')) active @endif">
                            <a href="{{ route('payroll.payslip.index') }}">Payslips </a>
                        </li>--}}
                        <li>
                            <a data-toggle="collapse" href="#reports" role="button" aria-expanded="@if($r->routeIs('payroll.reports*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('payroll.reports*')) active @endif">
                                Reports <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('payroll.reports*')) show @endif" id="reports">
                                <li class="@if($r->routeIs('payroll.reports.items-summary*')) active @endif">
                                    <a href="{{ route('payroll.reports.items-summary') }}">Items Summary</a>
                                </li>
                                <li class="@if($r->routeIs('payroll.reports.staff-per-item*')) active @endif">
                                    <a href="{{ route('payroll.reports.staff-per-item') }}">Staff Per Item</a>
                                </li>
                                <li class="@if($r->routeIs('payroll.reports.items-per-staff*')) active @endif">
                                    <a href="{{ route('payroll.reports.items-per-staff') }}">Items Per staff</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#items" role="button" aria-expanded="@if($r->routeIs('payroll.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('payroll.configurations*')) active @endif">
                                Configurations <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('payroll.configurations*')) show @endif" id="items">
                                <li class="@if($r->routeIs('payroll.configurations.items*')) active @endif">
                                    <a href="{{ route('payroll.configurations.items') }}"> Manage Items </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="accountingMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Accounting Module</h5>
{{--                        <p>Our being able to do what we like best.</p>--}}
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a data-toggle="collapse" href="#invoice" role="button" aria-expanded="@if($r->routeIs('accounting.invoices*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('accounting.invoices*')) active @endif">
                                Invoices <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('accounting.invoices*')) show @endif" id="invoice">
                                <li class="@if($r->routeIs('accounting.invoices.create*')) active @endif">
                                    <a href="{{ route('accounting.invoices.create') }}"> Create </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.invoices.index*')) active @endif">
                                    <a href="{{ route('accounting.invoices.index') }}"> Invoices </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.invoices.configuration*')) active @endif">
                                    <a href="{{ route('accounting.invoices.configuration') }}"> Configuration </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#business-partners" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Business Partners <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('accounting.business_partners*')) show @endif" id="business-partners">
                                <li class="@if($r->routeIs('accounting.business_partners.create*')) active @endif">
                                    <a href="{{ route('accounting.business_partners.create') }}"> Create </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.business_partners.index*')) active @endif">
                                    <a href="{{ route('accounting.business_partners.index') }}"> BP List </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#accounts" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Accounts <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('inventory.configurations*')) show @endif" id="accounts">
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> General Ledgers (GL) </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> Accounts </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">GL Account Code </a>
                        </li>
                        <li>
                            <a href="#"> Group Control Accounts </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="financialMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Financial Module</h5>
                        {{--                        <p>Our being able to do what we like best.</p>--}}
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a data-toggle="collapse" href="#invoice" role="button" aria-expanded="@if($r->routeIs('accounting.invoices*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('accounting.invoices*')) active @endif">
                                Invoices <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('accounting.invoices*')) show @endif" id="invoice">
                                <li class="@if($r->routeIs('accounting.invoices.create*')) active @endif">
                                    <a href="{{ route('accounting.invoices.create') }}"> Create </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.invoices.index*')) active @endif">
                                    <a href="{{ route('accounting.invoices.index') }}"> Invoices </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.invoices.configuration*')) active @endif">
                                    <a href="{{ route('accounting.invoices.configuration') }}"> Configuration </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#business-partners" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Business Partners <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('accounting.business_partners*')) show @endif" id="business-partners">
                                <li class="@if($r->routeIs('accounting.business_partners.create*')) active @endif">
                                    <a href="{{ route('accounting.business_partners.create') }}"> Create </a>
                                </li>
                                <li class="@if($r->routeIs('accounting.business_partners.index*')) active @endif">
                                    <a href="{{ route('accounting.business_partners.index') }}"> BP List </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#accounts" role="button" aria-expanded="@if($r->routeIs('inventory.configurations*')) true @else false @endif" aria-controls="collapseExample" class="dropdown-toggle @if($r->routeIs('inventory.configurations*')) active @endif">
                                Accounts <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse @if($r->routeIs('inventory.configurations*')) show @endif" id="accounts">
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> General Ledgers (GL) </a>
                                </li>
                                <li class="@if($r->routeIs('inventory.configurations.items*')) active @endif">
                                    <a href="{{ route('inventory.configurations.items.index') }}"> Accounts </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">GL Account Code </a>
                        </li>
                        <li>
                            <a href="#"> Group Control Accounts </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="formsMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Forms</h5>
                        <p>Et harum quidem rerum facilis et expedita.</p>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a data-toggle="collapse" href="#formControls" role="button" aria-expanded="false" aria-controls="collapseExample" class="dropdown-toggle">
                                Controls <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse" id="formControls">
                                <li>
                                    <a href="forms_controls_base_input.html"> Base Input </a>
                                </li>
                                <li>
                                    <a href="forms_controls_input_groups.html"> Input Groups </a>
                                </li>
                                <li>
                                    <a href="forms_controls_checkbox.html"> Checkbox </a>
                                </li>
                                <li>
                                    <a href="forms_controls_radio.html"> Radio </a>
                                </li>
                                <li>
                                    <a href="forms_controls_switch.html"> Switch </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#formWidgets" role="button" aria-expanded="false" aria-controls="collapseExample" class="dropdown-toggle">
                                Widgets <i class="las la-angle-right sidemenu-right-icon"></i>
                            </a>
                            <ul class="sub-submenu-list collapse" id="formWidgets">
                                <li>
                                    <a href="forms_widgets_picker.html"> Picker </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_tagify.html"> Tagify </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_touch_spin.html"> Touch Spin </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_maxlength.html"> Max Length </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_switch.html"> Switch </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_select_splitter.html"> Select Splitter</a>
                                </li>
                                <li>
                                    <a href="forms_widgets_bootstrap_select.html"> Bootstrap Select </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_select_2.html"> Select 2 </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_input_masks.html"> Input Masks </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_autogrow.html"> Autogrow </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_range_slider.html"> Range Slider </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_clipboard.html"> Clipboard </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_typeahead.html"> Typeahead </a>
                                </li>
                                <li>
                                    <a href="forms_widgets_captcha.html"> Captcha </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="forms_validation.html"> Validation </a>
                        </li>
                        <li>
                            <a href="forms_layouts.html"> Layouts </a>
                        </li>
                        <li>
                            <a href="forms_text_editor.html"> Text Editor </a>
                        </li>
                        <li>
                            <a href="forms_file_upload.html"> File Upload </a>
                        </li>
                        <li>
                            <a href="forms_multiple_step.html"> Multiple Step </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="staffMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Staff Module</h5>
{{--                        <p>Dashboard</p>--}}
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="#"> Dashboard </a>
                        </li>
                        <li>
                            <a href="{{ route('staff.my-payslips.index') }}"> My Payslip </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="chartsMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Charts</h5>
                        <p>Nemo enim ipsam voluptatem quia voluptas.</p>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="charts_apex_chart.html"> Apex Chart </a>
                        </li>
                        <li>
                            <a href="charts_chartlist.html"> Chartlist Charts </a>
                        </li>
                        <li>
                            <a href="charts_chartjs.html"> ChartJS </a>
                        </li>
                        <li>
                            <a href="charts_morris_chart.html"> Morris Charts </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="starterKitMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Starter Kit</h5>
                        <p>Adipisci velit, sed quia non numquam eius.</p>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a href="starter_kit_blank_page.html"> Blank Page </a>
                        </li>
                        <li class="active">
                            <a href="starter_kit_breadcrumbs.html"> Breadcrumbs </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="submenu" id="multiLevelMenu">
                <div class="submenu-info">
                    <div class="submenu-inner-info">
                        <h5 class="mb-3">Multi Level</h5>
                        <p>Quis autem vel eum iure reprehenderit qui.</p>
                    </div>
                    <ul class="submenu-list">
                        <li>
                            <a data-toggle="collapse" href="#multiLevelLevelTwo" role="button" aria-expanded="false" aria-controls="collapseExample" class="dropdown-toggle"> Level 2 <i class="las la-angle-right sidemenu-right-icon"></i> </a>
                            <ul class="collapse sub-submenu-list" id="multiLevelLevelTwo">
                                <li>
                                    <a href="javascript:void(0)"> Link 1 </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"> Link 2 </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a data-toggle="collapse" href="#multiLevelLevelThree" role="button" aria-expanded="false" aria-controls="collapseExample" class="dropdown-toggle"> Level 3 <i class="las la-angle-right sidemenu-right-icon"></i> </a>
                            <ul class="collapse sub-submenu-list" id="multiLevelLevelThree">
                                <li>
                                    <a href="javascript:void(0)"> Link 1</a>
                                </li>
                                <li>
                                    <a data-toggle="collapse" href="#multiLevelLevelThreeOne" role="button" aria-expanded="false" aria-controls="collapseExample" class="dropdown-toggle"> Link 2 <i class="las la-angle-right sidemenu-right-icon"></i> </a>
                                    <ul class="collapse list-unstyled sub-sub-submenu-list" id="multiLevelLevelThreeOne">
                                        <li>
                                            <a href="javascript:void(0)"> Link 1</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"> Link 2 </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
