@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button onclick="history.back()" class="btn btn-primary bg-gradient-danger">
                        <i class="las la-times"></i> Close
                    </button>
                </div>
                <h4 class="table-header mb-4">Create new item</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form id="addEditLocationForm" method="post" action="{{ route('inventory.items.store') }}">
                            @csrf
                            <input type="hidden" value="" name="location_id" id="location-id"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Item Code</label>
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Item code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Item Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Item name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Category</label>
                                        <select type="text" name="category_id" id="category_id" class="form-control">
                                            <option value="">--category--</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Branch</label>
                                        <select type="text" name="branch_id" id="branch_id" class="form-control">
                                            <option value="">--branch--</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Unit of Item</label>
                                        <select type="text" name="unit" id="unit" class="form-control">
                                            <option>--unit--</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->code }}">{{ $unit->name }} ({{ $unit->code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Brand</label>
                                        <input type="text" name="brand" id="brand" class="form-control" placeholder="Brand">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="alert_quantity">Alert Quantity</label>
                                        <input type="number" name="alert_quantity" id="alert_quantity" class="form-control" placeholder="Alert Quantity">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price">Unit Price</label>
                                        <input type="number" name="unit_price" id="unit_price" class="form-control" placeholder="Unit Price">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary bg-gradient-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endSection

@section('modals')
    <form action="" method="post" id="deleteLocationForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.coordinate').hide();

            $('.add-coordinate').change(function () {
                if ($(this).is(':checked')) {
                    $('.coordinate').slideDown();
                } else {
                    $('.coordinate').slideUp();
                }
            })

            $('body').on('click', '.edit, .add', function () {
                let location_id = $(this).attr('id')
                let name = $(this).attr('name')
                let latitude = $(this).attr('latitude')
                let longitude = $(this).attr('longitude')
                if (location_id) {
                    $('#location-id').val(location_id)
                    $('#name').val(name)
                    $('#latitude').val(latitude)
                    $('#longitude').val(longitude)
                } else {
                    $('#location-id').val("")
                    $('#name').val("")
                    $('#latitude').val("")
                    $('#longitude').val("")
                }

                $('#addEditLocationModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditLocationForm').submit();
                })
            });

            $('.saveLocation').click(function () {
                $('#addEditLocationForm').submit();
            })



            $('.widget-content .warning.delete').on('click', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('vehicles.location.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteLocationForm').attr('action', url)
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    confirmButtonClass: 'btn-danger',
                    padding: '2em'
                }).then(function (result) {
                    if (result.value) {
                        $('#deleteLocationForm').submit();
                    } else {
                        swal(
                            'You cancelled!',
                            'Your record is safe now.',
                            'error'
                        )
                    }
                })
            })


        });


    </script>
@endsection
