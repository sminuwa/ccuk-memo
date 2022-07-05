@extends('layouts.master')


@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-4 col-lg-4 col-md-4 mb-4">
            <div class="profile-left">
                <div class="image-area">
                    <img class="user-image" src="{{ myAsset('truck.png') }}">
                    <a href="#" class="follow-area">
                        <i class="las la-pen"></i>
                    </a>
                </div>
                <div class="info-area">
                    <h6>{{ $vehicle->name }} ({{ $vehicle->number }})</h6>
                    <p>{{ $vehicle->cassis }}</p>
                    <p>Account Number : {{ $vehicle->account()->number ?? null }}</p>
                    <button disabled>{{ $vehicle->status }}</button>
                </div>
                <div class="profile-numbers">
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat($vehicle->getCost()) }}</span>
                            <span class="number-detail">Cost</span>
                        </a>
                    </div>
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat($vehicle->getRevenue()) }}</span>
                            <span class="number-detail">Revenue</span>
                        </a>
                    </div>
                    <div class="single-number">
                        <a>
                            <span class="number">{{ thousandsCurrencyFormat($vehicle->getExpense()) }}</span>
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
        <div class="col-xl-8 col-lg-8 col-md-8">
            <div class="row tab-area-content">
                <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
                    <div class="tab-content" id="v-border-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-border-pills-home" role="tabpanel" aria-labelledby="v-border-pills-home-tab">
                            <div class="profile-shadow mb-3">
                                <h6 class="font-15 mb-4">Active Dispatch</h6>
                                @if($vehicle->activeDispatch())
                                    @php $dispatch = $vehicle->activeDispatch() @endphp
                                    <div id="toggleAccordionWithIconRotate{{ $dispatch->id }}" class="basic-accordion-icon rotate">
                                        <div class="card">
                                            <div class="card-header" id="basicAccordionIconheadingRotateOne{{ $dispatch->id }}">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="{{--@if(!$loop->first) collapsed @endif--}}" data-toggle="collapse" data-target="#basicAccordionIconRotateOne{{ $dispatch->id }}" aria-expanded="true" aria-controls="basicAccordionIconRotateOne{{ $dispatch->id }}">
                                                        <i class="las la-dot-circle font-20"></i>
                                                        {{ $dispatch?->number }} :
                                                        <a class="text-success" href="{{ route('memos.show', $dispatch?->memo->id ?? 0)}}">{{ $dispatch?->memo->reference }}</a>
                                                        {!! $dispatch->memo->getStatus()  !!}
                                                        <div class="icons"><i class="las la-angle-up has-rotate"></i></div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="basicAccordionIconRotateOne{{ $dispatch->id }}" class="collapse show {{--@if($loop->first) show @endif--}}" aria-labelledby="basicAccordionIconheadingRotateOne{{ $dispatch->id }}" data-parent="#toggleAccordionWithIconRotate{{ $dispatch->id }}">
                                                <div class="card-body">
                                                    <div class="media">
                                                        <div class="media-body">
{{--                                                            <h5 class="mt-0">Media heading</h5>--}}
                                                            <div class="single-team border-0">
                                                                <div class="d-flex">
                                                                    <div class="team-left">
                                                                        <div class="basic-counter-container">
                                                                            <span id="count1" class="font-20 text-primary strong">
                                                                                {{ $dispatch->totalForms() ?? 0}}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="team-right">

                                                                        <p class="mb-0 text-black">
                                                                            From: <i>{{ $dispatch?->date_from }}</i>
                                                                        </p>
                                                                        <ul class="mt-0">
                                                                            <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{ number_format($dispatch->getTotalRevenue() ?? 0) }} </li>
                                                                            <li class="text-danger mb-0"><strong>Expense</strong> : {{ number_format($dispatch->getTotalExpense() ?? 0) }} </li>
                                                                            <li class="text-warning"><strong>Driver %</strong> : {{ number_format($dispatch->driverPercentage() ?? 0) }} </li>
                                                                        </ul>
                                                                        @if($dispatch->memo->isApproved())
                                                                            <a href="{{ route('vehicles.forms.create', $vehicle->id) }}" class="btn bg-gradient-success btn-sm text-white"> Create Forms </a>
                                                                            <a href="{{ route('vehicles.dispatches.close',$dispatch?->id)}}" class="btn btn-sm bg-gradient-danger text-white"> Close </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table class="table table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th><div class="th-content">Type</div></th>
                                                                    <th><div class="th-content">Category</div></th>
                                                                    <th><div class="th-content">Amount</div></th>
                                                                    <th><div class="th-content">Action</div></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($dispatch->forms as $form)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <i class="las la-box font-20 mr-2"></i>
                                                                                <a class="text-secondary" href="{{ route('memos.show', $form->memo->id) }}">{{ $form->type }}</a>
                                                                            </div>
                                                                        </td>
                                                                        <td style="width: 300px;">@if($form->category == "Others") Mixed @else {{ $form->category }} @endif</td>
                                                                        <td width="30%">
                                                                            <span class="text-success-teal">{{ $form->revenue() }}</span>
                                                                            <span class="text-danger">{{ ' - '.$form->expense() }}</span>
                                                                        </td>
                                                                        <td>{!! $form->memo->getStatus() !!}</td>
                                                                        <td>
                                                                            @if($form->memo->isApproved())
                                                                                <span class="btn btn-sm btn-primary bg-gradient-primary"> Receipt </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @else
                                    {{--@if(!$vehicle->hasOpeningBalance())
                                        <div class="alert alert-warning">
                                            This vehicle does not have an opening balance.
                                            <a href="#" class="addOpeningBalance">Click here</a> to add
                                        </div>
                                    @else--}}
                                    <button class="btn bg-gradient-success btn-sm text-white addDispatch"> New dispatch </button>
{{--                                    @endif--}}
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
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="profile-info">
                                        <h5>Vehicle Information</h5>
                                        @if(!$vehicle->hasOpeningBalance())
                                            <div class="alert alert-warning">
                                                This vehicle does not have an opening balance.
                                                <a href="#" class="addOpeningBalance">Click here</a> to add
                                            </div>
                                        @endif

                                        <table class="table table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Account Number</th>
                                                <td>{{ $vehicle->account()->number ?? null }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Name</th>
                                                <td>{{ $vehicle->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Model</th>
                                                <td>{{ $vehicle->model }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cost</th>
                                                <td>{{ $vehicle->cost }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tonnage</th>
                                                <td>{{ $vehicle->tonnage }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Color</th>
                                                <td>{{ $vehicle->color }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cassis No.</th>
                                                <td>{{ $vehicle->cassis }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Fuel</th>
                                                <td colspan="2">{{ $vehicle->fuel }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Category</th>
                                                <td colspan="2">{{ $vehicle->category }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
{{--                                        @if($vehicle->hasOpeningBalance())--}}
                                            <div class="mt-3">
                                                <a href="{{ route('accounting.invoices.create',['model'=>class_basename($vehicle), 'model_id'=>$vehicle]) }}" class="btn btn-sm btn-success bg-gradient-success">Invoice</a>
                                                <a href="{{ route('accounting.payments.index') }}" class="btn btn-sm btn-primary bg-gradient-primary">Payment</a>
                                            </div>
{{--                                        @endif--}}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-dispatch" role="tabpanel" aria-labelledby="v-border-pills-dispatch-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-4">Vehicle Dispatch Records</h6>
                                    @if($vehicle->dispatches()->count() == 0)
                                        <button class="btn bg-gradient-success btn-sm text-white addDispatch"> New dispatch </button>
                                    @else
                                        @foreach($vehicle->dispatches() as $dispatch)
                                            <div id="toggleAccordionWithIconRotate{{ $dispatch->id }}" class="basic-accordion-icon rotate">
                                                <div class="card">
                                                    <div class="card-header" id="basicAccordionIconheadingRotateOne{{ $dispatch->id }}">
                                                        <section class="mb-0 mt-0">
                                                            <div role="menu" class="@if(!$loop->first) collapsed @endif" data-toggle="collapse" data-target="#basicAccordionIconRotateOne{{ $dispatch->id }}" aria-expanded="true" aria-controls="basicAccordionIconRotateOne{{ $dispatch->id }}">
                                                                <i class="las la-dot-circle font-20"></i>
                                                                {{ $dispatch?->number }} :
                                                                <a class="text-success" href="{{ route('memos.show', $dispatch?->memo->id ?? 0)}}">{{ $dispatch?->memo->reference }}</a>
                                                                {!! $dispatch->memo->getStatus()  !!}
                                                                <div class="icons"><i class="las la-angle-up has-rotate"></i></div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                    <div id="basicAccordionIconRotateOne{{ $dispatch->id }}" class="collapse @if($loop->first) show @endif" aria-labelledby="basicAccordionIconheadingRotateOne{{ $dispatch->id }}" data-parent="#toggleAccordionWithIconRotate{{ $dispatch->id }}">
                                                        <div class="card-body">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    {{--                                                            <h5 class="mt-0">Media heading</h5>--}}
                                                                    <div class="single-team border-0">
                                                                        <div class="d-flex">
                                                                            <div class="team-left">
                                                                                <div class="basic-counter-container">
                                                                            <span id="count1" class="font-20 text-primary strong">
                                                                                {{ $dispatch->totalForms() ?? 0}}
                                                                            </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="team-right">

                                                                                <p class="mb-0 text-black">
                                                                                    From: <i>{{ $dispatch?->date_from }}</i>
                                                                                </p>
                                                                                <ul class="mt-0">
                                                                                    <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{ number_format($dispatch->getTotalRevenue() ?? 0) }} </li>
                                                                                    <li class="text-danger mb-0"><strong>Expense</strong> : {{ number_format($dispatch->getTotalExpense() ?? 0) }} </li>
                                                                                    <li class="text-warning"><strong>Driver %</strong> : {{ number_format($dispatch->driverPercentage() ?? 0) }} </li>
                                                                                </ul>
                                                                                @if($dispatch->memo->isApproved())
                                                                                    <a href="{{ route('vehicles.forms.create', $vehicle->id) }}" class="btn bg-gradient-success btn-sm text-white"> Create Forms </a>
                                                                                    <a href="{{ route('vehicles.dispatches.close',$dispatch?->id)}}" class="btn btn-sm bg-gradient-danger text-white"> Close </a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th><div class="th-content">Type</div></th>
                                                                            <th><div class="th-content">Category</div></th>
                                                                            <th><div class="th-content">Amount</div></th>
                                                                            <th><div class="th-content">Action</div></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($dispatch->forms as $form)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-flex align-items-center">
                                                                                        <i class="las la-box font-20 mr-2"></i>
                                                                                        <a class="text-secondary" href="{{ route('memos.show', $form->memo->id) }}">{{ $form->type }}</a>
                                                                                    </div>
                                                                                </td>
                                                                                <td style="width: 300px;">@if($form->category == "Others") Mixed @else {{ $form->category }} @endif</td>
                                                                                <td width="30%">
                                                                                    <span class="text-success-teal">{{ $form->revenue() }}</span>
                                                                                    <span class="text-danger">{{ ' - '.$form->expense() }}</span>
                                                                                </td>
                                                                                <td>{!! $form->memo->getStatus() !!}</td>
                                                                                <td>
                                                                                    @if($form->memo->isApproved())
                                                                                        <span class="btn btn-sm btn-primary bg-gradient-primary"> Receipt </span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
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
                                                        <li class="text-success-teal mb-0"><strong>Revenue</strong> : {{thousandsCurrencyFormat(0)}} </li>
                                                        <li class="text-warning"><strong>Expense</strong> : {{thousandsCurrencyFormat(0)}} </li>

                                                    </ul>
                                                    @if($driver->to_date == null)
                                                        <button class="primary"> Active </button>
                                                    @else
                                                        <div class="badge badge-danger">Inactive</div>
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
                                    <h6 class="font-15 mb-4">
                                        Vehicle Statements (Account Number : {{ $vehicle->account()->number ?? null }})</h6>
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th><div class="th-content">#</div></th>
                                            <th><div class="th-content">Ref. Model</div></th>
                                            <th><div class="th-content">Amount</div></th>
                                            <th><div class="th-content">Type</div></th>
                                            <th><div class="th-content">Date</div></th>
                                            <th><div class="th-content">Action</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($vehicle->account())
                                            @foreach($vehicle->statements() as $statement)
                                            <tr class="text-danger">
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <a class="text-secondary" href="{{ route('memos.show',$statement?->referenceModel()?->memo?->id) }}">{{ implode(' ',preg_split('/(?=[A-Z])/', $statement->reference_model)) }}</a>
                                                </td>
                                                <td>
                                                    @if($statement->type == 'Credit')
                                                        <span class="text-success">{{ $statement->amount }}</span>
                                                    @else
                                                        <span class="text-danger">{{ $statement->amount }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $statement->type }}
                                                </td>
                                                <td>
                                                    {!! $statement->created_at !!}
                                                </td>
                                                <td>
                                                    <a href="{{ route('vehicles.forms.create', $vehicle->id) }}" class="btn bg-gradient-primary btn-sm text-white"> Receipt </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-border-pills-particulars" role="tabpanel" aria-labelledby="v-border-pills-particulars-tab">

                        </div>
                        <div class="tab-pane fade" id="v-border-pills-maintenance" role="tabpanel" aria-labelledby="v-border-pills-maintenance-tab">
                            <div class="media">
                                <div class="profile-shadow w-100">
                                    <h6 class="font-15 mb-4">Vehicle Maintenance Records</h6>
                                    <button class="btn bg-gradient-success btn-sm text-white addMaintenance"> New request </button>
                                    <table class="table table-hover mt-4">
                                        <thead>
                                        <tr>
                                            <th><div class="th-content">Form ID</div></th>
                                            <th><div class="th-content">Type</div></th>
                                            <th><div class="th-content">Amount</div></th>
                                            <th><div class="th-content">Status</div></th>
                                            <th><div class="th-content">Date</div></th>
                                            <th><div class="th-content">Action</div></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vehicle->maintenances as $maintenance)
                                            <tr>
                                                <td>
                                                    <a class="text-secondary" href="{{ route('memos.show', $maintenance?->memo->id ?? 0)}}">
                                                        {{ $maintenance?->reference }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $maintenance->type }}
                                                </td>
                                                <td>
                                                    {{ $maintenance->amount }}
                                                </td>
                                                <td>
                                                    {!! $maintenance->memo->getStatus() !!}
                                                </td>
                                                <td>
                                                    {!! $maintenance->created_at !!}
                                                </td>
                                                <td>
                                                    @if(!$maintenance->transactions() && $maintenance->memo->isApproved())
                                                    <a href="{{ route('vehicles.forms.create', $vehicle->id) }}" class="btn bg-gradient-primary btn-sm text-white"> Payment </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    <div id="addEditOpeningBalanceModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Vehicle Account Opening Balance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditOpeningBalanceForm" method="post" action="{{ route('accounting.transactions.opening-balance') }}">
                        @csrf
                        <input type="hidden" value="{{ $vehicle->id }}" name="model_id"/>
                        <input type="hidden" value="{{ class_basename($vehicle) }}" name="model_name"/>
                        <input type="hidden" value="{{ $vehicle->code }}" name="account_number"/>
                        <input type="hidden" value="{{ \App\Models\Transaction::TYPE_CREDIT }}" name="type"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GL Code</label>
                                    <select type="text" name="code" class="form-control account-gl">
                                       {{-- @php $codes = \App\Models\AccountLedger::orderBy('code','asc')->get(); @endphp
                                        <option> select</option>
                                        @foreach($codes as $code)
                                            <option value="{{ $code->code }}">{{ $code->code }} - {{ $code->description }}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveOpeningBalance">Save</button>
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

    <div id="addMaintenanceModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Maintenance request form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addMaintenanceForm" method="post" action="{{ route('memos.store') }}">
                        @csrf
                        <input type="hidden" value="Vehicle Maintenance Request" name="title"/>
                        <input type="hidden" value="{{ $vehicle->id }}" name="vehicle_id"/>
                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                        <input type="hidden" name="form_category" id="form_category" value="Maintenance" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Send to</label>
                                    <select type="text" name="sendto" class="form-control select2">
                                        {{-- @php $codes = \App\Models\AccountLedger::orderBy('code','asc')->get(); @endphp
                                         <option> select</option>
                                         @foreach($codes as $code)
                                             <option value="{{ $code->code }}">{{ $code->code }} - {{ $code->description }}</option>
                                         @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="maintenance_type" class="form-control" required>
                                        <option value="">--select--</option>
                                        <option>Routine</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" placeholder="Description (e.g. change of engine oil)"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveMaintenance">Save</button>
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


            //Opening balance
            $(document).on('click', '.addOpeningBalance', function(){
                $('#addEditOpeningBalanceModal').modal()
            });
            $('.saveOpeningBalance').click(function(){
                $("#addEditOpeningBalanceForm").submit();
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

            //Opening balance
            $(document).on('click', '.addMaintenance', function(){
                $('#addMaintenanceModal').modal()
            });
            $('.saveMaintenance').click(function(){
                $("#addMaintenanceForm").submit();
            })

            selectTwo('select2')
            glAccount('account-gl')
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
            function glAccount(param) {
                $('.' + param).select2({
                    placeholder: "Search account",
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        url: '{{ route('accounting.search-gl') }}',
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

