@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-danger bg-gradient-primary">
                        <i class="las la-plus-circle"></i> Close
                    </button>
                </div>
                <h4 class="table-header mb-4">Create payments</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="mb-4">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Send Request To:</label>
                                        <select name="sendto" class="form-control select2"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Form</label>
                                        <select name="form_type" id="revenue_form_type" class="form-control">
                                            <option></option>
                                            <option>{{ \App\Models\VehicleDispatchForm::TYPE_EXPENSE }}</option>
                                            <option>{{ \App\Models\VehicleDispatchForm::TYPE_FEEDING }}</option>
                                            <option>{{ \App\Models\VehicleDispatchForm::TYPE_FUEL }}</option>
                                            <option>{{ \App\Models\VehicleDispatchForm::TYPE_REPAIR }}</option>
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
    </div>
@endSection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function(){

            $('.fuel-request-form').hide();

            $('.add-fuel-request').change(function () {
                if ($(this).is(':checked')) {
                    $('.fuel-request-form').slideDown();
                } else {
                    $('.fuel-request-form').slideUp();
                }
            })

            $(document).on('keyup', '#amount_per_litre, #litre', function(){
                let amount = $("#amount_per_litre").val() * $("#litre").val();
                $('#amount').val(amount)
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
