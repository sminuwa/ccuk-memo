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
                <a href="{{ route('memos.index') }}" class="stats">
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
                <a href="{{ route('memos.index') }}" class="stats">
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
                <a href="{{ route('memos.index') }}" class="stats">
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
