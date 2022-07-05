@extends('layouts.master')


@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-3 col-lg-4 col-md-4 mb-4">
            <div class="profile-left">
                <div class="image-area">
                    <img class="user-image" src="{{ myAsset('truck.png') }}">
                    <a href="pages_profile_edit.html" class="follow-area">
                        <i class="las la-pen"></i>
                    </a>
                </div>
                <div class="info-area">
                    <h6>{{ $vehicle->name }} ({{ $vehicle->number }})</h6>
                    <p>{{ $vehicle->cassis }}</p>
                    <button disabled>{{ $vehicle->status }}</button>
                </div>
                <div class="profile-numbers">
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat(22000) }}</span>
                            <span class="number-detail">Cost</span>
                        </a>
                    </div>
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat(42000) }}</span>
                            <span class="number-detail">Revenue</span>
                        </a>
                    </div>
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat(12000) }}</span>
                            <span class="number-detail">Expense</span>
                        </a>
                    </div>
                </div>
                <div class="profile-tabs">
                    <div class="nav flex-column nav-pills mb-sm-0 mb-3 mx-auto" id="v-border-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-border-pills-home-tab" data-toggle="pill" href="#v-border-pills-home" role="tab" aria-controls="v-border-pills-home" aria-selected="true">Home</a>
                        <a class="nav-link" id="v-border-pills-dispatch-tab" data-toggle="pill" href="#v-border-pills-dispatch" role="tab" aria-controls="v-border-pills-dispatch" aria-selected="false">Dispatch</a>
                        <a class="nav-link" id="v-border-pills-driver-tab" data-toggle="pill" href="#v-border-pills-driver" role="tab" aria-controls="v-border-pills-driver" aria-selected="false">Drivers</a>
                        <a class="nav-link" id="v-border-pills-statement-tab" data-toggle="pill" href="#v-border-pills-statement" role="tab" aria-controls="v-border-pills-statement" aria-selected="false">Statement</a>
                        <a class="nav-link" id="v-border-pills-particulars-tab" data-toggle="pill" href="#v-border-pills-particulars" role="tab" aria-controls="v-border-pills-particulars" aria-selected="false">Particulars</a>
                        <a class="nav-link" id="v-border-pills-particulars-tab" data-toggle="pill" href="#v-border-pills-maintenance" role="tab" aria-controls="v-border-pills-particulars" aria-selected="false">Maintenance</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="row tab-area-content">
                <div class="col-xl-7 col-lg-12 col-md-12 mb-4">
                    <div class="tab-content" id="v-border-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-border-pills-home" role="tabpanel" aria-labelledby="v-border-pills-home-tab">
                            <div class="profile-shadow mb-3">
                                <h6 class="font-15 mb-4">Active Dispatch</h6>
                                @if($vehicle->activeDispatch())
                                    <div class="single-team border-0">
                                        <div class="d-flex">
                                            <div class="team-left">
                                                <div class="basic-counter-container">
                                                    <span id="count1" class="font-20 text-primary strong">0</span>
                                                </div>
                                            </div>
                                            <div class="team-right">
                                                <h6>{{ $vehicle->activeDispatch()?->number }} :
                                                    <a class="text-success" href="{{route('memos.show', $vehicle->activeDispatch()->memo->id)}}">{{ $vehicle->activeDispatch()->memo->reference }}</a></h6>
                                                <p class="mb-0 text-black">
                                                    From: <i>{{ $vehicle->activeDispatch()?->date_from }}</i>
                                                </p>
                                                <ul class="mt-0">
                                                    <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                    <li class="text-warning mb-0"><strong>Expense</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                    <li class="text-danger"><strong>Driver %</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                </ul>
                                                <button class="btn bg-gradient-primary btn-sm text-white addRevenue"> Revenue </button>
                                                <button class="btn bg-gradient-success btn-sm text-white addExpense"> Expense </button>
                                                <a href="{{ route('vehicles.dispatches.close',$vehicle->activeDispatch()?->id)}}" class="btn btn-sm bg-gradient-danger text-white"> Close </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button class="btn bg-gradient-success btn-sm text-white addDispatch"> New dispatch </button>
                                @endif
                            </div>
                            <div class="profile-shadow mb-3">
                                <h6 class="font-15 mb-4">Active Driver</h6>
                                @if($vehicle->activeDriver())
                                    <div class="single-team border-0">
                                        <div class="d-flex">
                                            <div class="team-left">
                                                <img src="{{ myAsset('master/assets/placeholders/user.jpg') }}" alt="Driver Passport" />
                                                <p>0 </p>
                                            </div>
                                            <div class="team-right">
                                                <h6>{{ $vehicle->activeDriver()?->driver->fullName() }}</h6>
                                                <p class="mb-0 text-black">
                                                    From: <i>{{ $vehicle->activeDriver()?->from_date }}</i>
                                                </p>
                                                <ul class="mt-0">
                                                    <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                    <li class="text-warning"><strong>Expense</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                </ul>
                                                <button class="primary changeDriver"> Change driver </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button class="btn bg-gradient-success btn-sm text-white changeDriver"> Add Driver </button>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-dispatch" role="tabpanel" aria-labelledby="v-border-pills-dispatch-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-4">Vehicle Dispatch Records</h6>
                                    @if(!$vehicle->dispatches())
                                        <button class="btn bg-gradient-success btn-sm text-white addDispatch"> New dispatch </button>
                                    @else
                                        @foreach($vehicle->dispatches() as $dispatch)
                                            <div class="single-team">
                                                <div class="d-flex">
                                                    <div class="team-left">
                                                        <div class="basic-counter-container">
                                                            <span id="count1" class="font-20 text-primary strong">0</span>
                                                        </div>
                                                    </div>
                                                    <div class="team-right">
                                                        <h6>{{ $dispatch->number }}</h6>
                                                        <p class="mb-0 text-black">
                                                            From: <i>{{ $dispatch->date_from }}</i>
                                                            @if($dispatch->date_to != null) To: <i>{{ $dispatch->date_to }}</i> @endif</p>

                                                        <ul class="mt-0">
                                                            <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                            <li class="text-warning"><strong>Expense</strong> : {{thousandsCurrencyFormat(0)}} </li>

                                                        </ul>
                                                        @if($dispatch->date_to == null)
                                                            <button class="btn bg-gradient-primary text-white addRevenue"> Revenue </button>
                                                            <button class="btn bg-gradient-success text-white addExpense"> Expense </button>
                                                            <a href="{{ route('vehicles.dispatches.close',$vehicle->activeDispatch()?->id)}}" class="btn bg-gradient-danger text-white"> Close </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="media">

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-driver" role="tabpanel" aria-labelledby="v-border-pills-driver-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-4">Drivers records</h6>
                                    @foreach($vehicle->drivers as $driver)
                                        <div class="single-team">
                                            <div class="d-flex">
                                                <div class="team-left">
                                                    <img src="{{ myAsset('master/assets/placeholders/user.jpg') }}" alt="Driver Passport" />
                                                    <p>0 Forms</p>
                                                </div>
                                                <div class="team-right">
                                                    <h6>{{ $driver->driver->fullName() }}</h6>
                                                    <p class="mb-0 text-black">
                                                        From: <i>{{ $driver->from_date }}</i>
                                                        @if($driver->to_date != null) To: <i>{{ $driver->to_date }}</i> @endif</p>

                                                    <ul class="mt-0">
                                                        <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{thousandsCurrencyFormat(40000)}} </li>
                                                        <li class="text-warning"><strong>Expense</strong> : {{thousandsCurrencyFormat(12000)}} </li>

                                                    </ul>
                                                    @if($driver->to_date == null)
                                                        <button class="primary"> Active </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-statement" role="tabpanel" aria-labelledby="v-border-pills-statement-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-3">Vehicle Statement</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th><div class="th-content">ID</div></th>
                                                <th><div class="th-content">Type</div></th>
                                                <th><div class="th-content">Amount</div></th>
                                                <th><div class="th-content">Action</div></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    Expense
                                                </td>
                                                <td>
                                                    100,000.00
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-black" title="" data-original-title="Print"><i class="las la-print"></i></a>
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-primary ml-2" title="" data-original-title="Details"><i class="las la-list"></i></a>
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-primary ml-2" title="" data-original-title="Edit"><i class="las la-pen"></i></a>
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-danger ml-2" title="" data-original-title="Delete"><i class="las la-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p class="font-13 text-center mt-4 mb-1 text-muted">
                                            <a class="text-primary" href="javascript:void(0);">Click here</a> to see the full statement for this vehicle
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-expenses" role="tabpanel" aria-labelledby="v-border-pills-expenses-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-3">Expense</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th><div class="th-content">ID</div></th>
                                                <th><div class="th-content">Status</div></th>
                                                <th><div class="th-content">Details</div></th>
                                                <th><div class="th-content">Action</div></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    <span class="badge badge-success-teal light">Approved</span>
                                                </td>
                                                <td>
                                                    <a href="apps_ecommerce_order_details.html" class="btn btn-sm btn-info">Details</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-primary" title="" data-original-title="Edit"><i class="las la-pen"></i></a>
                                                        <a href="javascript:void(0);" class="bs-tooltip font-20 text-danger ml-2" title="" data-original-title="Delete"><i class="las la-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p class="font-13 text-center mt-4 mb-1 text-muted">
                                            <a class="text-primary" href="javascript:void(0);">Click here</a> to see the full product list
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-particulars" role="tabpanel" aria-labelledby="v-border-pills-particulars-tab">

                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-12 col-md-12">
                    <div class="profile-info">
                        <h5>Vehicle Information</h5>
                        <div class="alert alert-warning">This vehicle does not have an opening balance</div>
                        <div class="single-profile-info">
                            <h6>Driver's Percentage</h6>
                            <p>{{ $vehicle->driverPercentage()?->value }}</p>
                        </div>
                        <div class="single-profile-info">
                            <h6>Local Fuel Price ({{ $vehicle->fuel }})</h6>
                            <p>{{ getFuelPrice($vehicle->fuel)?->price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<article class="postcard light green text-left">
        <a class="postcard__img_link" href="#">
            <img class="postcard__img" src="{{ myAsset('truck.png') }} {{ myAsset('assets/img/truck.jpg') }}" alt="Vehicle Picture" />
        </a>
        <div class="postcard__text t-dark">
            <h1 class="postcard__title green"><a href="#">{{ $vehicle->name }} ({{ $vehicle->code }})</a></h1>
            <div class="postcard__subtitle small">
                <strong><i class="fa fa-calendar-check-o"></i> Date Purchased: </strong> {{ $vehicle->date_purchased }}
            </div>
            <div class="postcard__subtitle small">
                <strong><i class="fa fa-file-o"></i> Particulars Expiry: </strong> {!! $vehicle->getParticularExpiryDate() !!}
            </div>
            <div class="postcard__subtitle small">
                <strong><i class="fa fa-tint"></i> Fuel Price (Per Litre): </strong> {!! $vehicle->getFuel()->price ?? '<span class="text-danger">No Fuel configuration</span>' !!}
            </div>
            <div class="postcard__subtitle small">
                <strong><i class="fa fa-truck"></i> Vehicle Status: </strong> {!! $vehicle->status() !!}
            </div>
            <div class="postcard__bar"></div>
            <div class="postcard__preview-txt">
                <h5 style="font-size:18px;">
                    <a href="#"><small>Cost:</small> {{ $vehicle->getCost() }}</a> <span style="color:#aaaaaa;">|</span>
                    <a href="#"><small>Revenue:</small> {{ $vehicle->getRevenue() }}</a> <span style="color:#aaaaaa;">|</span>
                    <a href="#"><small>Expenses:</small> {{ $vehicle->getExpense() }}</a>
                </h5>
            </div>

            <ul class="postcard__tagbox">
                <li class="tag__item disabled"><i class=" mr-2"></i>Model: {{ $vehicle->model }}</li>
                <li class="tag__item"><i class=" mr-2"></i>Color: {{ $vehicle->color }}</li>
                <li class="tag__item"><i class=" mr-2"></i>Fuel Type: {{ $vehicle->fuel }}</li>
            </ul>
        </div>

    </article>
    <div class="row" >
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success mb-0">{{ session('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger mb-0">{{ session('error') }}</div>
            @endif
            <nav>
                <div class="nav nav-tabs bg-light" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-transport-tab" data-toggle="tab" href="#nav-transports" role="tab" aria-controls="nav-home" aria-selected="true">Transports</a>
                    <a class="nav-link" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuels" role="tab" aria-controls="nav-fuels" aria-selected="false">Fuels</a>
                    <a class="nav-link" id="nav-bills-tab" data-toggle="tab" href="#nav-bills" role="tab" aria-controls="nav-bills" aria-selected="false">Carriage</a>
                    <a class="nav-link" id="nav-drivers-tab" data-toggle="tab" href="#nav-drivers" role="tab" aria-controls="nav-drivers" aria-selected="false">Drivers</a>
                    <a class="nav-link" id="nav-supervisor-tab" data-toggle="tab" href="#nav-supervisors" role="tab" aria-controls="nav-supervisors" aria-selected="false">Supervisors</a>
                    <a class="nav-link" id="nav-particulars-tab" data-toggle="tab" href="#nav-particulars" role="tab" aria-controls="nav-particulars" aria-selected="false">Particulars</a>
                    <a class="nav-link" id="nav-spare-parts-tab" data-toggle="tab" href="#nav-spare-parts" role="tab" aria-controls="nav-spare-parts" aria-selected="false">Parts</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade py-4 px-4 bg-white show active" id="nav-transports" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="bd-example" data-example-id="">
                                <div id="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach($vehicle->dispatches() as $dispatch)
                                        <div class="card shadow-none">
                                            <div class="card-header" role="tab" id="heading{{$loop->iteration}}">
                                                <div class="mb-0 btn_body">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $loop->iteration }}">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <span class="badge badge-success mr-4">{{ $loop->iteration }}</span>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <h3>
                                                                    {{ $dispatch->number }} | {{ $dispatch->vehicleDriver->driver->fullName() }}
                                                                    <div class="mr-3" style="float: right"> {!! $dispatch->getStatus()  !!}</div>
                                                                </h3>
                                                                <p>From: <span style="font-style: italic;">{{ $dispatch->date_from  }}</span> To: {!! $dispatch->date_to != "" ? $dispatch->date_to : '<span class="badge badge-default">In Transit</span>'  !!}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                </div>
                                            </div>

                                            <div id="collapse{{ $loop->iteration }}" class="collapse" role="tabpanel" aria-labelledby="heading{{ $loop->iteration }}" aria-expanded="false" style="">
                                                <div class="card-block">
                                                    Information goes here
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="shadow-lg px-3 py-3 rounded">
                                @if($dispatch = $vehicle->activeDispatch())
                                    <h5 class="card-title">Active Dispatch Details</h5>
                                    <table>
                                        <tr>
                                            <th style="font-size:12px;">Driver:</th>
                                            <td style="font-size:12px;">{{ $dispatch->vehicleDriver->driver->fullName() ?? null}}</td>
                                        </tr>
                                    </table>
                                @else
                                    <h5 class="card-title">New Dispatch</h5>
                                    <form method="post" action="{{ route('memos.store') }}">
                                        @csrf
                                        <input type="hidden" name="title" value="Vehicle Dispatch Request" />
                                        <input type="hidden" name="vehicle_driver_id" value="{{ $vehicle->activeDriver()?->id }}" />
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                                        <input type="hidden" name="form_type" value="{{ \App\Models\VehicleDispatchForm::TYPE_DISPATCH }}" />
                                        <input type="hidden" name="form_category" value="{{ \App\Models\VehicleDispatchForm::CATEGORY_OTHERS }}" />
                                        <input type="hidden" name="is_dispatch" value="true" />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Send To:</label>
                                                    <select class="form-control mySelect3" name="sendto" style="width:100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button  class="btn btn-info btn-sm btn-dispatch-request" style="margin:0;">Send Request</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-fuels" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">Fueling Requests</h5>
                            <table class="display table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Litres</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                --}}{{--@foreach($vehicle->fuels() as $fuel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $fuel->number  }}</td>
                                        <td>{{ $fuel->date_from  }}</td>
                                        <td>{!! $fuel->date_to != "" ? $dispatch->date_to : '<i class="badge badge-success">In Transit</i>'  !!}</td>
                                        <td>{!! $fuel->getStatus()  !!}</td>
                                        <td><a href="#"><i class="badge badge-dark">7 forms</i></a></td>
                                    </tr>
                                @endforeach--}}{{--
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="shadow-lg px-3 py-3 rounded border border-success">
                                @if(!$vehicle->activeDriver())
                                    <p class="card-title text-danger"><strong>Note:</strong> You cannot request for fuel without active dispatch</p>
                                @else
                                    <h5 class="card-title">New Request</h5>
                                    <form method="post" action="{{ route('memos.store') }}">
                                        @csrf
                                        <input type="hidden" name="title" value="Vehicle Dispatch Request" />
                                        <input type="hidden" name="vehicle_driver_id" value="{{ $vehicle->activeDriver()?->id }}" />
                                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                                        <input type="hidden" name="form_type" value="{{ \App\Models\VehicleDispatchForm::TYPE_FUEL }}" />
                                        <input type="hidden" name="form_category" value="{{ \App\Models\VehicleDispatchForm::CATEGORY_EXPENSE }}" />
                                        <input type="hidden" name="is_dispatch" value="" />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Send To:</label>
                                                    <select class="form-control mySelect3" name="sendto" style="width:100%;"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fuel-litre">Litres:</label>
                                                    <input type="number" class="form-control" name="litre" id="fuel-litre">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fuel-amount">Amount:</label>
                                                    <input type="text" readonly class="form-control" name="amount" id="fuel-amount" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-danger">
                                            <strong>Note:</strong> All fuel requests would use the active vehicle dispatch request details
                                        </p>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button  class="btn btn-info btn-sm btn-dispatch-request" style="margin:0;">Send Request</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-bills" role="tabpanel" aria-labelledby="nav-bills-tab">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">Drivers Record</h5>
                            <table id="" style="width:100%" class="display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Started</th>
                                    <th>Ended</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehicle->drivers as $driver)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $driver->driver->fullName() ?? null}}</td>
                                        <td>{{ $driver->from_date }}</td>
                                        <td>{{ $driver->to_date != "" ? $driver->to_date : "Present" }}</td>
                                        <td>
                                            {!! $driver->status == "active" ? '<i class="badge badge-success">Active</i>' : '<i class="badge badge-danger">Inactive</i>' !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title">Change Driver</h5>
                            <form method="post" action="{{ route('vehicles.driver.change', $vehicle->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Driver's Name:</label>
                                            <select class="form-control mySelect3" name="driver_name" style="width:100%;"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-info btn-sm" style="margin:0;">Change</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-drivers" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">Drivers Record</h5>
                            <table id="" style="width:100%" class="display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Started</th>
                                    <th>Ended</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehicle->drivers as $driver)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $driver->driver->fullName() ?? null}}</td>
                                        <td>{{ $driver->from_date }}</td>
                                        <td>{{ $driver->to_date != "" ? $driver->to_date : "Present" }}</td>
                                        <td>
                                            {!! $driver->status == "active" ? '<i class="badge badge-success">Active</i>' : '<i class="badge badge-danger">Inactive</i>' !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h5 class="card-title">Change Driver</h5>
                            <form method="post" action="{{ route('vehicles.driver.change', $vehicle->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Driver's Name:</label>
                                            <select class="form-control mySelect3" name="driver_name" style="width:100%;"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-info btn-sm" style="margin:0;">Change</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-supervisors" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-header">
                            <div style="float: right">
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-truck"></i> Change</a>
                            </div>
                            <h5 class="card-title">Supervisor's Record</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" class="display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date Started</th>
                                    <th>Date Ended</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Sunusi Mohd Inuwa</td>
                                    <td>19/01/2021</td>
                                    <td>12/04/2021</td>
                                    <td><i class="badge badge-success">Active</i></td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-particulars" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-header">
                            <div style="float: right">
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-truck"></i> Change</a>
                            </div>
                            <h5 class="card-title">Particulars</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" class="display">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date Issued</th>
                                    <th>Date Expired</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Roadworthness</td>
                                    <td>20th August 2021</td>
                                    <td>20th August 2022</td>
                                    <td><i class="badge badge-success">Valid</i></td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm ">Delete</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade py-4 px-4 bg-white" id="nav-spare-parts" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-header">
                            <div style="float: right">
                                <a href="#" class="btn btn-success btn-sm"><i class="fa fa-truck"></i> Request</a>
                            </div>
                            <h5 class="card-title">Sparepart request records</h5>
                        </div>
                        <div class="card-body">
                            <table width="100%" class="table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Alias</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>00212</td>
                                    <td>Shocks Absorber</td>
                                    <td>Chocks</td>
                                    <td>26-09-2021</td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm ">Delete</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endSection

@section('modals')

    <div id="addEditVehicleModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditVehicleForm" method="post" action="{{ route('vehicles.store') }}">
                        @csrf
                        <input type="hidden" value="" name="route_id" id="route_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Route Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="direction">Direction</label>
                                    <input type="text" name="direction" id="direction" class="form-control" placeholder="Direction">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveVehicle">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="changeDriverModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Change Driver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changeDriverForm" method="post" action="{{ route('vehicles.driver.change', $vehicle->id) }}">
                        @csrf
                        <input type="hidden" value="{{ $vehicle->id }}" name="vehicle_id" id="vehicle_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <select name="driver_name" id="driver_name" class="form-control select2"></select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveDriver">Change</button>
                </div>
            </div>
        </div>
    </div>

    @include('pages.vehicles.vehicles.modals.dispatch-form')

    <div id="dispatchRevenueModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Revenue forms</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dispatchRevenueForm" method="post" action="{{ route('memos.store') }}">
                        @csrf
                        <input type="hidden" name="title" value="title" />
                        <input type="hidden" name="vehicle_driver_id" value="{{ $vehicle->activeDriver()?->id }}" />
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                        <input type="hidden" name="form_category" value="{{ \App\Models\VehicleDispatchForm::CATEGORY_EXPENSE }}" />
                        <input type="hidden" name="is_dispatch" value="true" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Send Request To:</label>
                                    <select name="sendto" class="form-control select2"></select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Form</label>
                                    <select name="form_type" id="revenue_form_type" class="form-control">
                                        <option></option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_CARRIAGE }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_OTHERS }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row revenue-form-container">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveRevenue">Change</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dispatchExpenseModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Expense forms</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dispatchExpenseForm" method="post" action="{{ route('memos.store') }}">
                        @csrf
                        <input type="hidden" name="title" value="Expense Form" />
                        <input type="hidden" name="vehicle_driver_id" value="{{ $vehicle->activeDriver()?->id }}" />
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                        <input type="hidden" name="form_category" value="{{ \App\Models\VehicleDispatchForm::CATEGORY_EXPENSE }}" />
                        <input type="hidden" name="is_dispatch" value="false" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Send Request To:</label>
                                    <select name="sendto" id="vehicle_dispatch_sendto" class="form-control select2"></select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Form</label>
                                    <select name="form_type" id="expense_form_type" class="form-control">
                                        <option></option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_EXPENSE }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_FEEDING }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_FUEL }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_REPAIR }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row expense-form-container">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Filling station</label>
                                    <input name="filling_station" type="text" class="form-control" placeholder="Filling Station">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Route</label>
                                    <select name="filling_station" type="text" class="form-control">
                                        <option value="custom">Custom</option>
                                        @php $location_routes = \App\Models\LocationRoute::all() @endphp
                                        @foreach($location_routes as $route)
                                            <option>{{ $route->route->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Litre</label>
                                    <input name="litre" type="text" class="form-control" placeholder="Litre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input name="amount" type="text" class="form-control" placeholder="Amount">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveExpense">Change</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteVehicleForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection



@section('js')
    @include('pages.vehicles.vehicles.scripts.modals')
    <script>
        $(document).ready(function(){

            $('.revenue-form-container').hide();
            $('.expense-form-container').hide();
            $('#expense_form_type').change(function(){
                $('.expense-form-container').show();
            })

            //Vehicle Driver
            $(document).on('click', '.changeDriver', function() {
                $('#changeDriverModal').modal();
            });
            $('.saveDriver').click(function(){
                $("#changeDriverForm").submit();
            })

            //Dispatch
            $(document).on('click', '.addDispatch', function(){
                $('#vehicleDispatchModal').modal()
            });
            $('.saveVehicleDispatch').click(function(){
                $("#vehicleDispatchForm").submit();
            })

            //Revenue
            $(document).on('click', '.addRevenue', function(){
                $('#dispatchRevenueModal').modal()
            })
            $('.saveRevenue').click(function(){
                $('#dispatchRevenueForm').submit();
            });

            //Expense
            $(document).on('click', '.addExpense', function(){
                $('#dispatchExpenseModal').modal()
            })
            $('.saveExpense').click(function(){
                $('#dispatchExpenseForm').submit();
            });


            selectTwo('select2')
            function selectTwo(param) {
                $('.' + param).select2({
                    placeholder: "Search name",
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        url: '{{ route('users.search.user','all') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public'
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            }
                        }
                        , cache: true
                    }
                });
            }

        });
    </script>
@endsection

