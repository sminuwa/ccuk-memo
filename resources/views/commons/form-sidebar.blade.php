@auth('web')
    @php
        $user = Auth::user();
        $r = request();
    @endphp
    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="https://www.creative-tim.com" class="simple-text logo-mini">
                <div class="logo-image-small">
                    <img src="{{ myAsset('assets/img/logo-small.png') }}">
                </div>
                <!-- <p>CT</p> -->
            </a>

            <a  class="simple-text logo-normal">
                Forms
                <!-- <div class="logo-image-big">
                  <img src="../assets/img/logo-big.png">
                </div> -->
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="@if($r->routeIs('forms.dashboard*')) active @endif">
                    <a href="{{ route('forms.dashboard') }}">
                        <i class="nc-icon nc-diamond"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{--            @if($user->canAccess('memos.index'))--}}
                <li class="@if($r->routeIs('forms.meal_allowances*')) active @endif">
                    <a href="{{ route('forms.meal_allowances.index') }}">
                        <i class="nc-icon nc-palette"></i>
                        <p>Meal Allowance</p>
                    </a>
                </li>
                <li class="@if($r->routeIs('forms.cash_advances*')) active @endif">
                    <a href="{{ route('messages.index') }}">
                        <i class="nc-icon nc-money-coins"></i>
                        <p>Cash Advance</p>
                    </a>
                </li>
                <li class="@if($r->routeIs('forms.housing_allowances*')) active @endif">
                    <a href="{{ route('memos.index') }}">
                        <i class="nc-icon nc-bank"></i>
                        <p>Housing Allowance</p>
                    </a>
                </li>
                <li class="@if($r->routeIs('forms.authority_to_pay*')) active @endif">
                    <a href="{{ route('users.show', auth()->id()) }}">
                        <i class="nc-icon nc-badge"></i>
                        <p>Authority To Pay</p>
                    </a>
                </li>

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
