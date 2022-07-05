@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="javascript:history.back();" class="btn btn-danger bg-gradient-primary">
                        <i class="las la-plus-circle"></i> Close
                    </a>
                </div>
                <h4 class="table-header mb-4">Create form</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif
                <div class="row">
                <div class="col-xl-4 col-lg-4 col-sm-12 border-0 border-primary ">
                    <h5>Vehicle Details</h5>
                    <table class="table table-sm mb-0 mt-4">
                        <tbody>
                        <tr>
                            <th scope="row">Account Code</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->code }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Name</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->name }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Model</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->model }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Cost</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->cost }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Tonnage</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->tonnage }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Color</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->color }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Cassis No.</th>
                            <td><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->cassis }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Fuel</th>
                            <td colspan="2"><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->fuel }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Category</th>
                            <td colspan="2"><a class="text-primary" href="{{ route('vehicles.show', $vehicle->id) }}">{{ $vehicle->category }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Dispatch No.</th>
                            <td><a class="text-primary" href="{{ route('memos.show',$vehicle->activeDispatch()->memo_id) }}">{{ $vehicle->activeDispatch()->number }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Driver Name.</th>
                            <td>{{ $vehicle->activeDriver()->driver->fullName() }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-xl-8 col-lg-8 col-sm-12">
                    <form id="createForm" method="post" action="{{ route('memos.store') }}">
                        @csrf
                        <input type="hidden" name="title" id="form-title" value="title" />
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}" />
                        <input type="hidden" name="type" value="{{ \App\Models\Memo::TYPE_VEHICLE }}" />
                        <input type="hidden" name="form_category" id="form_category" value="" />
                        <input type="hidden" name="vehicle_dispatch_id" value="{{ $vehicle->activeDispatch()->id}}" />
                        <input type="hidden" name="vehicle_driver_id" value="{{ $vehicle->activeDriver()->id}}" />
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Send Request To:</label>
                                    <select name="sendto" class="form-control select2"></select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Select Form</label>
                                    <select name="form_type" id="form_type" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_CARRIAGE }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_FUEL }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_REPAIR }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_FEEDING }}</option>
                                        <option>{{ \App\Models\VehicleDispatchForm::TYPE_OTHERS }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-container">

                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12 col-sm-12">
{{--                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>--}}
                            <button type="submit" class="btn btn-primary saveForm">Create</button>
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

            $('#form_type').change(function(){
                let type = $(this).val();
                $('#form-title').val(type+" Form Request")
                if(type === "{{ \App\Models\VehicleDispatchForm::TYPE_CARRIAGE }}") {
                    $('.form-container').html(carriage)
                    $('#form_category').val("{{ \App\Models\VehicleDispatchForm::CATEGORY_REVENUE }}")
                    $('.has-commission-option').change(function () {
                        console.log('Hello')
                        if ($(this).is(':checked')) {
                            // $('.commission-box').slideDown();
                            $('.commission-box').html(`
                                <label>Commission</label>
                                <input name="commission" type="number" class="form-control form-control-sm" placeholder="Commission" required>
                            `).slideDown();
                        } else {
                            $('.commission-box').slideUp();

                        }
                    })
                }else if(type === "{{ \App\Models\VehicleDispatchForm::TYPE_FUEL }}") {
                    $('.form-container').html(fuel)
                    $('#form_category').val("{{ \App\Models\VehicleDispatchForm::CATEGORY_EXPENSE }}")
                }
            })

            let carriage = `
                <div class="row animated slideInRight carriage-bill-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Shipped From (Address)</label>
                            <input name="shipped_from" type="text" class="form-control" placeholder="Shipped From">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Shipped To (Address)</label>
                            <input name="shipped_to" type="text" class="form-control" placeholder="Shipped To">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Items and Description</label>
                            <input name="item" type="text" class="form-control" placeholder="E.g. 2000 bag of Dangote Cement ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Transportation Cost</label>
                            <input name="cost" type="number" class="form-control" placeholder="Total Cost">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mt-3">
                            <label></label>
                            <div class="ripple-checkbox-primary">
                                <input name="has_commission" class="inp-cbx has-commission-option" id="cbx1" type="checkbox" style="display: none">
                                <label class="cbx" for="cbx1">
                                <span>
                                    <svg width="12px" height="10px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                    <span class="text-light-black">Has Commission</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group commission-box">

                        </div>
                    </div>
                </div>
            `;
            let fuel = `
                <div class="row animated slideInRight fuel-request-form">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Filling station</label>
                            <input name="filling_station" type="text" class="form-control" placeholder="Filling Station">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Route</label>
                            <select name="route" type="text" class="form-control" required>
                                <option value=""> --Select-- </option>
                                @php $location_routes = \App\Models\LocationRoute::all() @endphp
                                @foreach($location_routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->route->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Litre</label>
                            <input name="litre" id="litre" type="number" class="form-control" placeholder="Litre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount Per Litre</label>
                            <input name="amount_per_litre" id="amount_per_litre" type="number" class="form-control" placeholder="Amount Per Litre">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input name="amount" id="amount" type="number" class="form-control" placeholder="Amount" readonly>
                        </div>
                    </div>
                </div>
                `;

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
