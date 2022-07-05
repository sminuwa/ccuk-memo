@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing ">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-danger bg-gradient-primary">
                        <i class="las la-plus-circle"></i> Close
                    </button>
                </div>
                <h4 class="table-header mb-4">Create Invoice</h4>
                <h4 class="table-header mb-4 text-success">Invoice details</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <table class="table table-sm mb-0 table-borderless">
                            <tbody>
                            <tr>
                                <th scope="row">Invoice Reference: </th>
                                <td>{{ $reference }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Site: </th>
                                <td>{{ $site->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">User: </th>
                                <td>{{ auth()->user()->fullName() }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Model: </th>
                                <td>{{ $model }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <form id="dispatchRevenueForm" method="post" action="{{ route('accounting.invoices.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Item:</label>
                                        <input name="detail_item[]" class="form-control form-control-sm" placeholder="Item" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Account:</label>
                                        <input name="detail_account[]" class="form-control form-control-sm" placeholder="Account" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Amount:</label>
                                        <input type="number" name="detail_amount[]" class="form-control form-control-sm" placeholder="Amount" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input name="detail_item[]" class="form-control form-control-sm" placeholder="Item" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input name="detail_account[]" class="form-control form-control-sm" placeholder="Account" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="number" name="detail_amount[]" class="form-control form-control-sm" placeholder="Amount" required>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                    <div class="form-group">
                                        <a href="javascript:;" class="btn btn-danger bg-gradient-danger px-1"><i class="las la-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <a href="javascript:;" class="btn btn-success bg-gradient-success"><i class="las la-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="form-group text-right">
                                        <a href="javascript:;" class="btn">Cancel</a>
                                        <button type="submit" class="btn btn-primary bg-gradient-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
