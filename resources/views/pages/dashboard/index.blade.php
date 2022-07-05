@extends('layouts.app')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">{{ greetings() }} ({{ $user?->details()?->gender == 'Male' ? "Sir":"Madam" }}), {{ $user->fullName() }}</h5>
                </div>
                <div class="card-body">
                    {{--<p class="font-weight-bold text-danger">
                        This is to inform you that from now on all memos would not be available after one month of lifespan.
                        You are expected to clear your all memos as soon as it gets to your table.
                        Thank you.
                    </p>
                    <p> <strong>Note: </strong> This message is for testing purpose.</p>--}}
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <h4 class="col-lg-12 col-md-12 col-sm-12">My Memo</h4>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->twoHoursMemos()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'myhour') }}" class="stats">
                        Last 2 hours
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->twoDaysMemos()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'myday') }}" class="stats">
                        Last 2 days
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->oneWeekMemos()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'myweek') }}" class="stats">
                        Last week
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">All Memos</p>
                                <p class="card-title">{{ $user->memos()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.index') }}" class="stats">
                        All Memos
                    </a>
                </div>
            </div>
        </div>
    </div>
    @if($user->canAccess('dashboard.all-memos'))
    <div class="row">
        <h4 class="col-lg-12 col-md-12 col-sm-12">All Memo</h4>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->twoHoursMemosAll()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'hour') }}" class="stats">
                        Last 2 hours
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->twoDaysMemosAll()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'day') }}" class="stats">
                        Last 2 days
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Unread</p>
                                <p class="card-title">{{ $user->oneWeekMemosAll()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'week') }}" class="stats">
                        Last week
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-paper text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">All Memos</p>
                                <p class="card-title">{{ $user->memosAll()->count() }}<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <hr>
                    <a href="{{ route('memos.all', 'all') }}" class="stats">
                        All Memos
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
