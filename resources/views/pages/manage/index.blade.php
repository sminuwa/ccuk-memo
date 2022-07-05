@extends('layouts.app')

@section('content')
    @php $user = Auth::user(); $r = request(); @endphp

    <h3 class="mb-4"><i class="nc-icon nc-settings"></i> Settings</h3>
    <div class="row w-100">
        @if($user->canAccess('branch.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-info mx-sm-1 p-3">
                    <div class="card border-info shadow text-info p-3 my-card"><span class="fa fa-dashboard" aria-hidden="true"></span></div>
                    <div class="text-info text-center mt-4"><h5>FACULTIES</h5></div>
                    <div class="text-info text-center mt-1"><h1>{{ $branches }}</h1></div>
                    <a href="{{ route('branch.index') }}" class="btn btn-info btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
        @if($user->canAccess('department.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-success mx-sm-1 p-3">
                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-home" aria-hidden="true"></span>
                    </div>
                    <div class="text-success text-center mt-4"><h5>DEPARTMENTS</h5></div>
                    <div class="text-success text-center mt-1"><h1>{{ $departments }}</h1></div>
                    <a href="{{ route('department.index') }}" class="btn btn-success btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
        @if($user->canAccess('position.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-danger mx-sm-1 p-3">
                    <div class="card border-danger shadow text-danger p-3 my-card"><span class="fa fa-home" aria-hidden="true"></span></div>
                    <div class="text-danger text-center mt-4"><h5>POSITIONS</h5></div>
                    <div class="text-danger text-center mt-1"><h1>{{ $positions }}</h1></div>
                    <a href="{{ route('position.index') }}" class="btn btn-danger btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
        @if($user->canAccess('group.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-warning mx-sm-1 p-3">
                    <div class="card border-warning shadow text-warning p-3 my-card"><span class="fa fa-users" aria-hidden="true"></span></div>
                    <div class="text-warning text-center mt-4"><h5>GROUPS</h5></div>
                    <div class="text-warning text-center mt-1"><h1>{{ $groups }}</h1></div>
                    <a href="{{ route('group.index') }}" class="btn btn-warning btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
        @if($user->canAccess('role.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-info mx-sm-1 p-3">
                    <div class="card border-info shadow text-info p-3 my-card"><span class="fa fa-list-alt" aria-hidden="true"></span></div>
                    <div class="text-info text-center mt-4"><h5>ROLES</h5></div>
                    <div class="text-info text-center mt-1"><h1>{{ $roles }}</h1></div>
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
{{--        @if($user->canAccess('messages.index'))--}}
            <div class="col-md-3 mb-2">
                <div class="card border-success mx-sm-1 p-3">
                    <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-envelope-o" aria-hidden="true"></span></div>
                    <div class="text-success text-center mt-4"><h5>MESSAGES</h5></div>
                    <div class="text-success text-center mt-1"><h1>{{ $messages }}</h1></div>
                    <a href="{{ route('messages.index') }}" class="btn btn-success btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
{{--        @endif--}}
        @if($user->canAccess('users.index'))
            <div class="col-md-3 mb-2">
                <div class="card border-danger mx-sm-1 p-3">
                    <div class="card border-danger shadow text-danger p-3 my-card"><span class="fa fa-users" aria-hidden="true"></span></div>
                    <div class="text-danger text-center mt-4"><h5>STAFF</h5></div>
                    <div class="text-danger text-center mt-1"><h1>{{ $staff }}</h1></div>
                    <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
        @if($user->canAccess('payroll.module'))
            <div class="col-md-3 mb-2">
                <div class="card border-warning mx-sm-1 p-3">
                    <div class="card border-warning shadow text-warning p-3 my-card"><span class="fa fa-users" aria-hidden="true"></span></div>
                    <div class="text-warning text-center mt-4"><h5>PAYROLL</h5></div>
                    <div class="text-warning text-center mt-1"><h1>-</h1></div>
                    <a href="{{ route('payroll.staff.index') }}" class="btn btn-warning btn-sm">Manage <i class="nc-icon nc-settings"></i></a>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('css')
    <style>
        .my-card {
            position: absolute;
            left: 38%;
            top: -20px;
            border-radius: 50%;
        }
    </style>
@endsection

@push('js')

@endpush
