@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Add New Vehicles</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="post" action="{{ route('vehicles.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="eg. 001" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Brand Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Brand Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" class="form-control" name="model" placeholder="Model">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Number plate</label>
                                    <input type="text" class="form-control" name="number" placeholder="eg. AE709DRA">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cassis Number</label>
                                    <input type="text" class="form-control" name="cassis" placeholder="Cassis Number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select type="text" class="form-control" name="category" required>
                                        <option value=""> --caegory-- </option>
                                        <option>Car</option>
                                        <option>Crane</option>
                                        <option>Truck</option>
                                        <option>Tanker</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select  class="form-control" name="type" required>
                                        <option value="">  --select type-- </option>
                                        <option>Normal</option>
                                        <option>Tangle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="text" class="form-control" name="cost" placeholder="Purchase cost">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date of Purchase</label>
                                    <input type="date" class="form-control" name="date_bought">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>New / Second hand</label>
                                    <select  class="form-control" name="new_second" required>
                                        <option value="">  -- new / second -- </option>
                                        <option>New</option>
                                        <option>Second</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fuel</label>
                                    <select type="text" class="form-control" name="fuel" required>
                                        <option value=""> --fuel type-- </option>
                                        <option>Diesel</option>
                                        <option>Petrol</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tonnage</label>
                                    <input type="number" class="form-control" name="tonnage" placeholder="Tonnage">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <select type="text" class="form-control" name="color" required>
                                        <option value=""> --color-- </option>
                                        <option>White</option>
                                        <option>Ash</option>
                                        <option>Maroon</option>
                                        <option>Chocolate</option>
                                        <option>Red</option>
                                        <option>Green</option>
                                        <option>Blue</option>
                                        <option>Yellow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
@endSection


@section('css')
    <style>
        span.relative svg {
            width: 14px;
            height: 14px;
        }

        table tr a{
            color:#0c2646;
        }
    </style>
@endsection

@section('js')

    <script>
        $(document).ready(function () {
            //alert('df');
            $("#add-vehicle-btn").on("click",function (e) {
                $("#add-vehicle-modal").modal();
            });

            $("[tag-type='datatable']").DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "scrollX": true
            });
        });

        function doDropDown(id, url, type, data, childId, callback, dropdownName) {

            $.ajax({
                type: type,
                data: data,
                url: url,
                success: function (response) {
                    // $(childId).empty()
                    label = dropdownName ? dropdownName : capitalizeFLetter(childId);
                    html = "<option value=''>Select " + label + "</option>";
                    $.each(response, function (index, value) {
                        html += "<option value='" + value.id + "'>" + value.name + "</option>"

                    });
                    $("#" + childId).html(html);
                    if (callback)
                        callback();
                }
            });
        }
    </script>
@endsection
