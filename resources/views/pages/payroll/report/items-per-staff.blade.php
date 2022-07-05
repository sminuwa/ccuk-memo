

@extends('layouts.master')

@section('content')
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="">
                <div class="widget-content searchable-container grid">
                    <div class="card-box">
                        <h4 class="table-header mb-4">Report of payment item per staff</h4>
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
                                    <form class="reportForm" method="POST" action="{{ route('payroll.reports.items-per-staff') }}" >
                                        @csrf
                                        <div class="row" style="text-align: center">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                <div class="input-group">
                                                    <select name="staff_id" class="form-control select2"></select>
                                                </div>
                                            </div>
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
                                        </div>
                                        <div class="row">
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
        $(document).ready(function () {
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

        $(document).on('submit', '.reportForm', function(e){
            e.preventDefault();
            let data = $(this).serialize()
            $.ajax({
                type: "POST",
                url: "{{ route('payroll.reports.items-per-staff') }}",
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
