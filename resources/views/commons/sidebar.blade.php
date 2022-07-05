@auth('web')
    @php $user = Auth::user(); $r = request(); @endphp
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">

        <a  class="simple-text logo-normal text-center" style="color:white">
            CAPITAL CITY UNIVERSITY
            <!-- <div class="logo-image-big">
              <img src="../assets/img/logo-big.png">
            </div> -->
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="@if($r->routeIs('dashboard*')) active @endif">
                <a href="{{ route('dashboard') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="@if($r->routeIs('memos*') || $r->routeIs('memos.all*') || $r->routeIs('memos.show*') || $r->routeIs('forms*') || $r->routeIs('memos.create*')) active @endif ">
                <a href="{{ route('memos.index') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>Memos</p>
                </a>
            </li>

            @if($user->canAccess('reports.index'))
                <li class="@if($r->routeIs('reports*')) active @endif">
                    <a href="{{ route('reports.index') }}">
                        <i class="nc-icon nc-chart-bar-32"></i>
                        <p>Reports</p>
                    </a>
                </li>
            @endif
            <li class="@if($r->routeIs('manage*')) active @endif">
                <a href="{{ route('manage') }}">
                    <i class="nc-icon nc-settings"></i>
                    <p>Manage</p>
                </a>
            </li>
            @if($user->canAccess('expenditure_codes.index'))
                <li class="@if($r->routeIs('expenditure_codes*')) active @endif">
                    <a href="{{ route('expenditure_codes.index') }}">
                        <i class="nc-icon nc-money-coins"></i>
                        <p>Expenditure Codes</p>
                    </a>
                </li>
            @endif
            @if($user->canAccess('newsfeed.index'))
                <li class="@if($r->routeIs('newsfeed*')) active @endif">
                    <a href="{{ route('newsfeed.index') }}">
                        <i class="nc-icon nc-album-2"></i>
                        <p>News Deed</p>
                    </a>
                </li>
            @endif
            @if($user->canAccess('newsfeed.index'))
            <li class="@if($r->routeIs('backup*')) active @endif">
                <a href="{{ route('backup.index') }}">
                    <i class="nc-icon nc-album-2"></i>
                    <p>DB Backup</p>
                </a>
            </li>
            @endif
            <li class="@if($r->routeIs('payroll.staff.my-payslip*')) active @endif">
                <a href="{{ route('staff.my-payslips.index') }}">
                    <i class="nc-icon nc-settings"></i>
                    <p>My Payslip</p>
                </a>
            </li>
            <li class="@if($r->routeIs('users.show*')) active @endif">
                <a href="{{ route('users.show', auth()->id()) }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Profile</p>
                </a>
            </li>
            @if($user->canAccess('activities-log.index'))
                <li class="@if($r->routeIs('activities*')) active @endif">
                    <a href="{{ route('activities.index') }}">
                        <i class="nc-icon nc-key-25"></i>
                        <p>Activity Log</p>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route("auth.logout") }}">
                    <i class="fa fa-sign-out"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </div>
</div>
@endauth
