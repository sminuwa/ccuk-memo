<div id="vehicleDispatchModal" class="modal animated {{ modalAnimation() }}" role="dialog">
    <div class="modal-dialog {{ modalClasses() }}">
        <!-- Modal content-->
        <div class="modal-content {{ modalPadding() }}">
            <div class="modal-header">
                <h5 class="modal-title">Create vehicle dispatch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="vehicleDispatchForm" method="post" action="{{ route('memos.store') }}">
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
                                <label>Send Request To:</label>
                                <select name="sendto" class="form-control select2"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row carriage-bill-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shipped From (Address)</label>
                                <input name="shipped_from" type="text" class="form-control form-control-sm" placeholder="Shipped From">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shipped To (Address)</label>
                                <input name="shipped_to" type="text" class="form-control form-control-sm" placeholder="Shipped To">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Items and Description</label>
                                <input name="item" type="text" class="form-control form-control-sm" placeholder="E.g. 2000 bag of Dangote Cement ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Transportation Cost</label>
                                <input name="cost" type="number" class="form-control form-control-sm" placeholder="Total Cost">
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
                    <div class="form-group">
                        <div class="ripple-checkbox-primary">
                            <input name="fuel_option" class="inp-cbx add-fuel-request" id="cbx" type="checkbox" style="display: none">
                            <label class="cbx" for="cbx">
                                    <span>
                                        <svg width="12px" height="10px" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                <span class="text-light-black">Add fuel request form</span>
                            </label>
                        </div>
                    </div>
                    <div class="row fuel-request-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filling station</label>
                                <input name="filling_station" type="text" class="form-control form-control-sm" placeholder="Filling Station">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Route</label>
                                <select name="route" type="text" class="form-control form-control-sm" required>
                                    <option value=""> --Select-- </option>
                                    @php $location_routes = \App\Models\LocationRoute::all() @endphp
                                    @foreach($location_routes as $route)
                                        <option>{{ $route->route->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Litre</label>
                                <input name="litre" id="litre" type="number" class="form-control form-control-sm" placeholder="Litre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount Per Litre</label>
                                <input name="amount_per_litre" id="amount_per_litre" type="number" class="form-control form-control-sm" placeholder="Amount Per Litre">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount</label>
                                <input name="amount" id="amount" type="number" class="form-control form-control-sm" placeholder="Amount" readonly>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                <button type="button" class="btn btn-primary saveVehicleDispatch">Change</button>
            </div>
        </div>
    </div>
</div>

