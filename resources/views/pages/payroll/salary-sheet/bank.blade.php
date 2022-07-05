@extends('layouts.master')

@section('content')
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="">
                <div class="widget-content searchable-container grid">
                    <div class="card-box">
                        <form class="filter-form" action="{{ route('payroll.salary.bank.branch-salary-bank') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-center">
                                    <div class="input-group">
                                        <input id="basicExample" name="month" @if(isset($month)) value="{{$month}}" @endif class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select month...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
                                    <div class="input-group">
                                        <select id="bank" name="bank" class="form-control flatpickr flatpickr-input active" required>
                                            <option class="">All</option>
                                            @foreach($banks as $b)
                                                <option @if(isset($bank)) @if($b->id == $bank->id) selected @endif @endif value="{{ $b->id }}">{{ $b->name }}</option>
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
                                    @if(isset($bank)) <h6 class="m-0 text-danger">Bank Name: {{ $bank->name }}</h6> @endif
                                    <h6 class="m-0"> BY: {{ auth()->user()->completeName() }}</h6>
                                </div>
                            </div>

                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        @foreach($banks as $bnk)
                                            @if(count($bnk->salaryStaff()) == 0) @continue @endif
                                            @if(isset($bank)) @if($bnk->id != $bank->id) @continue @endif @endif
                                            <h4 class="text-warning">{{ $bnk->name }}</h4>
                                            <table class="table table-bordered">
                                                <thead class="">
                                                <tr>
                                                    <th scope="col" width="2%">S.No</th>
                                                    <th scope="col" width="30%">Employee Name</th>
                                                    <th scope="col">Account Number</th>
                                                    <th scope="col">Bank Name</th>
                                                    <th class="text-right" width="10%" scope="col">Net Salary</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $totalGross = $totalDeduction = $totalOtherDeduction = $totalNet = 0 @endphp
                                                @foreach($bnk->salaryStaff() as $staff)
{{--                                                    @php $totalNet += ($staff->totalNet($type) /12) - ($staff->totalOtherDeductions($type) + $staff->totalOtherAllowances($type)); @endphp--}}
                                                    @php $totalNet += (($staff->totalNet($type) / 12) - $staff->totalOtherDeductions($type)) + $staff->totalOtherAllowances($type); @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>{{ $staff->completeName() }}</td>
                                                        <td>{{ $staff->account_number }}</td>
                                                        <td>{{ $staff->bank }}</td>
                                                        <td class="text-right">
                                                            {{ number_format((($staff->totalNet($type) / 12) - $staff->totalOtherDeductions($type)) + $staff->totalOtherAllowances($type), 2) }}
{{--                                                            {{ number_format(($staff->totalNet($type) / 12) - ($staff->totalOtherDeductions($type) + $staff->totalOtherAllowances($type)), 2) }}--}}
{{--                                                            {{ number_format(($staff->totalNet($type) / 12) - ($staff->totalOtherDeductions($type) + $staff->totalOtherAllowances($type)), 2) }}--}}
                                                            {{--@if($type=='Other')
                                                                {{ number_format(($staff->totalNet($type) / 12) + $staff->totalOtherAllowances($type), 2) }}
                                                            @else

                                                            @endif--}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="4" class="text-left">Total</th>
                                                    <th class="text-right">{{ number_format($totalNet, 2) }} </th>
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
