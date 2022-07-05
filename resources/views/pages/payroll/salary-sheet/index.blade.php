@extends('layouts.master')

@section('content')
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="">
                <div class="widget-content searchable-container grid">
                    <div class="card-box">
                        <form class="filter-form" action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-center">
                                    <div class="input-group">
                                        <input id="basicExample" name="month" @if(isset($month)) value="{{$month}}" @endif class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select month...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
                                    <div class="input-group">
                                        <select id="branch" name="branch" class="form-control flatpickr flatpickr-input active" required>
                                            <option class="">All</option>
                                            @foreach($branches as $b)
                                                <option @if(isset($branch)) @if($b->id == $branch->id) selected @endif @endif value="{{ $b->id }}">{{ $b->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
                                    <div class="input-group">
                                        <select id="type" name="type" class="form-control flatpickr flatpickr-input active" required>
                                            <option @if(isset($type)) @if($type == "Regular") selected @endif @endif>Regular</option>
                                            <option @if(isset($type))  @if($type == "Other") selected @endif @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-left">
                                    <button class="btn btn-primary" type="submit">GO</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-box">
                        <div class="text-right">
{{--                            <a href="{{ route('payroll.salary.sheet.make-payment') }}" class="btn btn-primary bg-gradient-success"><i class="las la-print"></i> Make Payment</a>--}}
                            <button class="btn btn-primary bg-gradient-primary" onclick="print()"><i class="las la-print"></i> Print</button>
                        </div>
                        <div id="section-to-print" class="content-section py-1 animated animatedFadeInUp fadeInUp">
                            <div class="row inv--head-section mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <div class="company-info">
                                        <img src="{{ myAsset("logo.jpg") }}" width="150"/>
                                    </div>
                                    <h3 class="m-0">CAPITAL CITY UNIVERSITY, KANO</h3>
                                    <h5 class="m-0 bg-gradient-primary" style="color:white">
                                        Salary sheet for @if(isset($month)) {{ date("F, Y", strtotime($month)) }} @else {{ date('F, Y') }}  @endif
                                    </h5>
                                    @if(isset($branch)) <h6 class="m-0 text-danger">Branch Name: {{ $branch->name }}</h6> @endif
                                    <h6 class="m-0"> BY: {{ auth()->user()->fullName() }}</h6>
                                </div>
                            </div>

                           {{-- <div class="row inv--product-table-section my-4">
                                <div class="col-12">
                                    <h2>Summary</h2>
                                    <div class="table-responsive">
                                        @php $summaryTotalGross = $summaryTotalDeduction = $totalOtherDeductions = $totalOtherAllowances = $summaryTotalNet = 0 @endphp
                                        @foreach($branches as $bch)
                                            @if(count($bch->salaryStaff()) == 0) @continue @endif
                                            @if(isset($branch)) @if($bch->id != $branch->id) @continue @endif @endif
                                            @foreach($bch->salaryStaff() as $staff)
                                                @php
                                                    $summaryTotalGross += $staff->totalGross($type);
                                                    $summaryTotalDeduction += $staff->totalDeductions($type);
                                                    $totalOtherDeductions += $staff->totalOtherDeductions($type);
                                                    $totalOtherAllowances += $staff->totalOtherAllowances($type);
                                                    $summaryTotalNet += $staff->totalNet($type);
                                                @endphp
                                            @endforeach
                                        @endforeach
                                        <table class="table table-bordered w-50">
                                            <tbody>
                                            <tr>
                                                <th scope="col">Total Gross Salary</th>
                                                <td class="text-right">
                                                    {{ number_format(($summaryTotalGross / 12) + $totalOtherAllowances, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Total Deductions</th>
                                                <td class="text-right">
                                                    {{ number_format(($summaryTotalDeduction / 12) + $totalOtherDeductions, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Total Net</th>
                                                <td class="text-right">
                                                    {{ number_format((($summaryTotalNet / 12)-$totalOtherDeductions) + $totalOtherAllowances, 2)}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        @foreach($branches as $bch)
                                            @if(count($bch->salaryStaff()) == 0) @continue @endif
                                            @if(isset($branch)) @if($bch->id != $branch->id) @continue @endif @endif
                                            <h4 class="text-warning">{{ $bch->name }}</h4>
                                            <table class="table table-bordered">
                                                <thead class="">
                                                <tr>
                                                    <th scope="col" width="2%">S.No</th>
                                                    <th scope="col" width="30%">Employee Name</th>
                                                    <th scope="col" width="30%">Designation</th>
                                                    <th class="text-right " width="12%" scope="col">Gross Salary</th>
                                                    <th class="text-right" width="15%" scope="col">Total Deduction</th>
                                                    <th class="text-right" width="10%" scope="col">Net Salary</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $totalGross = $totalDeduction = $totalNet = $totalOtherAllowance = $totalOtherDeduction = 0 @endphp
                                                @foreach($bch->salaryStaff() as $staff)
                                                    @php
                                                        $totalGross += $staff->totalGross($type);
                                                        $totalDeduction += $staff->totalDeductions($type);
                                                        $totalNet += $staff->totalNet($type);
                                                        $totalOtherAllowance += $staff->totalOtherAllowances($type);
                                                        $totalOtherDeduction += $staff->totalOtherDeductions($type);
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $staff->fullName() }}</td>
                                                        <td>{{ $staff->position()->name ?? null }} ({{ $staff->level() }}/{{ $staff->step() }})</td>
                                                        <td class="text-right">
{{--                                                            @if($type == 'Other')--}}
                                                                {{ number_format(($staff->totalGross($type) / 12) + $staff->totalOtherAllowances($type), 2) }}

{{--                                                            @else--}}
{{--                                                                {{ number_format(($staff->totalGross($type) / 12)/* + $staff->totalOtherAllowances($type)*/, 2) }}--}}
{{--                                                            @endif--}}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ number_format(($staff->totalDeductions($type) / 12) + $staff->totalOtherDeductions($type), 2) }}
                                                        </td>
                                                        <td class="text-right">
{{--                                                            @if($type == 'Other')--}}
                                                            {{ number_format((($staff->totalNet($type) / 12) - $staff->totalOtherDeductions($type)) + $staff->totalOtherAllowances($type), 2) }}
{{--                                                            @else--}}
{{--                                                                {{ number_format((($staff->totalNet($type) / 12) - $staff->totalOtherDeductions($type)) /*+ $staff->totalOtherAllowances($type)*/, 2) }}--}}
{{--                                                            @endif--}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-left">Total</th>
                                                    <th class="text-right"></th>
                                                    <th class="text-right">{{ number_format(($totalGross / 12) + $totalOtherAllowance, 2) }}</th>
                                                    <th class="text-right">{{ number_format(($totalDeduction / 12) + $totalOtherDeduction, 2) }}</th>
                                                    <th class="text-right">{{ number_format((($totalNet / 12) - $totalOtherDeduction) + $totalOtherAllowance, 2) }}</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <h6 class=" inv-title">This is Salary sheet of only one month</h6>
                                </div>
                            </div>
                            <div class="footer-contact">
                                <div class="row">
                                    <div class="col-sm-12 col-12">
                                        <p class="">Email: payroll@albabello.com &nbsp;|&nbsp; Contact: 08135067070 &nbsp;|&nbsp; Website: www.albabello.com</p>
                                    </div>
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
    <div id="addEditLocationModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditLocationForm" method="post" action="{{ route('vehicles.location.store') }}">
                        @csrf

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveLocation">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteLocationForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@push('css')
    <link href="{{ myAsset('master/assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/apps/ecommerce.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table td, .table th {
            padding: 0.1rem;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush

@section('js')
    <script src="{{ myAsset('master/assets/js/apps/ecommerce.js') }}"></script>
    <script>
        $(document).ready(function () {
           /* $('.branch').change(function () {
                $('.filter-form').submit();
            });*/
        });
    </script>
@endsection
