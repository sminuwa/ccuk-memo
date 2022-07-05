@extends('layouts.master')

@section('content')
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="">
                <div class="widget-content searchable-container grid">
                    <div class="card-box">
                        <h4 class="table-header mb-4">Salary Item Summary Report</h4>
                        <div class="text-right">
                            {{--                            <a href="{{ route('payroll.salary.sheet.make-payment') }}" class="btn btn-primary bg-gradient-success"><i class="las la-print"></i> Make Payment</a>--}}
                        </div>
                        <div class="content-section py-lg-5 animated animatedFadeInUp fadeInUp">
                            @if(session()->has('success'))
                                <div class="alert alert-success"> {{ session('success') }}</div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger"> {{ session('error') }}</div>
                            @endif
                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <form class="reportForm" method="POST" action="{{ route('payroll.reports.items-summary') }}" >
                                        @csrf
                                        <div class="row" style="text-align: center">

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                <div class="input-group">
                                                    <select id="month" name="month" class="form-control">
                                                        @foreach($months as $month)
                                                            <option value="{{ $month->month_value }}">{{ $month->month_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                <div class="input-group">
                                                    <button class="btn btn-success bg-gradient-success" type="submit">Generate</button>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="report-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@push('css')
    <link href="{{ myAsset('master/assets/css/apps/invoice.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/ui-elements/pagination.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/apps/ecommerce.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .table td, .table th {
            padding: 0.1rem 10px;
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

        $(document).on('submit', '.reportForm', function(e){
            e.preventDefault();
            let data = $(this).serialize()
            $.ajax({
                type: "POST",
                url: "{{ route('payroll.reports.items-summary') }}",
                data: data,
                beforeSend: function(){

                },
                success: function(response){
                    $('.report-content').html(response)
                    console.log(response)
                }
            })
        })
    </script>
@endsection


{{--@extends('layouts.master')

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
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-left">
                                    <button class="btn btn-primary" type="submit">GO</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-box">
                        <div class="text-right">
                            <button class="btn btn-primary bg-gradient-primary" onclick="print()"><i class="las la-print"></i> Print</button>
                        </div>
                        <div id="section-to-print" class="content-section py-1 animated animatedFadeInUp fadeInUp w-100">
                            <div class="row inv--head-section mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <div class="company-info">
                                        <img src="{{ myAsset("logo.jpg") }}"/>
                                    </div>
                                    <h3 class="m-0">CAPITAL CITY UNIVERSITY, KANO</h3>
                                    <h5 class="m-0 bg-gradient-primary" style="color:white">
                                        Pay reconciliation for current month - @if(isset($month)) {{ date("F, Y", strtotime($month)) }} @else {{ date('F, Y') }}  @endif
                                    </h5>
                                    @if(isset($bank)) <h6 class="m-0 text-danger">Bank Name: {{ $bank->name }}</h6> @endif
                                    <h6 class="m-0"> BY: {{ auth()->user()->completeName() }}</h6>
                                </div>
                            </div>

                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <h4 class="text-warning">Incomes</h4>
                                        <table class="table table-bordered w-100">
                                            <thead class="">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Code</th>
                                                <th>Item</th>
                                                <th width="15%">MTD</th>
                                                <th width="15%">YTD</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $totalIncomeMTD = $totalIncomeYTD = 0 @endphp
                                            @foreach($salaryItems as $item)
                                                @php
                                                    $totalIncomeMTD += $item->mtd;
                                                    $totalIncomeYTD += $item->ytd;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }} ({{ $item->type }})</td>
                                                    <td width="15%" class="text-right">{{ number_format($item->mtd,2) }}</td>
                                                    <td width="15%" class="text-right">{{ number_format($item->ytd + $item->mtd,2) }}</td>
                                                </tr>
                                            @endforeach
                                            @foreach($salaryItems->where('type', 'Allowance') as $item)
                                                @php
                                                    $totalIncomeMTD += $item->mtd;
                                                    $totalIncomeYTD += $item->ytd;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration+1 }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-right">{{ number_format($item->mtd,2) }}</td>
                                                    <td class="text-right">{{ number_format($item->ytd + $item->mtd,2) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3">Total</th>
                                                --}}{{--                                                <th>Total</th>--}}{{--
                                                <th class="text-right">{{ number_format(($totalIncomeMTD), 2) }}</th>
                                                <th class="text-right">{{ number_format(($totalIncomeYTD + $totalIncomeMTD), 2) }}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        @php
                                            $MTDContribution = $totalIncomeMTD * .1;
                                            $YTDContribution = ($totalIncomeYTD + $totalIncomeMTD) * .1
                                        @endphp
                                        <h4 class="text-warning">Deductions</h4>
                                        <table class="table table-bordered w-100">
                                            <thead class="">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Code</th>
                                                <th>Item</th>
                                                <th width="15%">MTD</th>
                                                <th width="15%">YTD</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $totalDeductionMTD = $totalDeductionYTD = 0 @endphp
                                            @foreach($salaryItems->where('type', 'Deduction') as $item)
                                                 @php
                                                    $totalDeductionMTD += $item->mtd;
                                                    $totalDeductionYTD += $item->ytd;
                                                 @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-right">{{ number_format($item->mtd,2) }}</td>
                                                    <td class="text-right">{{ number_format($item->ytd + $item->mtd,2) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3">Total</th>
--}}{{--                                                <th>Total</th>--}}{{--
                                                <th class="text-right">{{ number_format(($totalDeductionMTD), 2) }}</th>
                                                <th class="text-right">{{ number_format(($totalDeductionYTD + $totalDeductionMTD), 2) }}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <h4 class="text-warning">Company Contributions</h4>
                                        <table class="table table-bordered w-100">
                                            <thead class="">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="10%">Code</th>
                                                <th>Item</th>
                                                <th width="15%">MTD</th>
                                                <th width="15%">YTD</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td>9001</td>
                                                    <td>Pension Fund (In House)</td>
                                                    <td class="text-right" >{{ number_format($MTDContribution,2) }}</td>
                                                    <td class="text-right">{{ number_format($YTDContribution,2) }}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3">Total</th>
                                                --}}{{--                                                <th>Total</th>--}}{{--
                                                <th class="text-right">{{ number_format($MTDContribution, 2) }}</th>
                                                <th class="text-right">{{ number_format($YTDContribution, 2) }}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        @php
                                            $MTDGrossPay = $totalIncomeMTD;
                                            $YTDGrossPay = $totalIncomeYTD;
                                            $MTDNetPay = ($totalIncomeMTD + $totalDeductionMTD);
                                            $YTDNetPay = ($totalIncomeYTD + $totalDeductionYTD);
                                            $MTDCompanyCost = $totalIncomeMTD + $MTDContribution;
                                            $YTDCompanyCost = $totalIncomeYTD + $YTDContribution;
                                        @endphp
                                        <table class="table table-bordered w-100">
                                            <thead class="">
                                            <tr>
                                                <th colspan="3">Item</th>
                                                <th width="15%">MTD</th>
                                                <th width="15%">YTD</th>
                                            </tr>
                                            </thead>
                                            <tbody class="">
                                            <tr>
                                                <th colspan="3">Gross Pay</th>
                                                <th width="15%" class="text-right">{{ number_format($MTDGrossPay, 2) }}</th>
                                                <th width="15%" class="text-right">{{ number_format($YTDGrossPay, 2) }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Net Pay</th>
                                                <th width="15%" class="text-right">{{ number_format($MTDNetPay, 2) }}</th>
                                                <th width="15%" class="text-right">{{ number_format($YTDNetPay, 2) }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">Company Cost</th>
                                                <th width="15%" class="text-right">{{ number_format($MTDCompanyCost, 2) }}</th>
                                                <th width="15%" class="text-right">{{ number_format($YTDCompanyCost, 2) }}</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12 col-12 text-center">
                                    <h6 class=" inv-title">This is sheet of only one month</h6>
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
            padding: 0.1rem .7rem;
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
@endsection--}}
