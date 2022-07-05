@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add fuel price
                    </button>
                </div>
                <h4 class="table-header mb-4">Fuel Price Configurations</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="table-responsive mb-4">
                    <table class="export-data table" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Term</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fuels as $fuel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $fuel->name }}</td>
                                <td>{{ $fuel->price }}</td>
                                <td>{{ $fuel->term }}</td>
                                <td>{{ $fuel->date_from }}</td>
                                <td>{{ $fuel->date_to }}</td>
                                <td>{!! $fuel->status() !!}</td>
                                <td class="text-right">
                                    @if(!$fuel->closed())
                                        <a href="#" title="Edit" class="font-20 text-primary edit"
                                           id="{{ $fuel->id }}"
                                           name="{{ $fuel->name }}"
                                           price="{{ $fuel->price }}"
                                           term="{{ $fuel->term }}"
                                           date-from="{{ $fuel->date_from }}"
                                           date-to="{{ $fuel->date_to }}"
                                        >
                                            <i class="las la-edit"></i>
                                        </a>
                                    @endif
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $fuel->id }}" >
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endSection

@section('modals')
    <div id="addEditFuelPriceModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Fuel Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditFuelPriceForm" method="post" action="{{ route('vehicles.fuel_price.store') }}">
                        @csrf
                        <input type="hidden" value="" name="fuel_id" id="fuel_id" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Diesel">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="e.g. 163">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="term">Term</label>
                                    <input type="text" name="term" id="term" class="form-control" placeholder="e.g. KMS">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveFuelPrice">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteFuelPriceForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('body').on('click', '.edit, .add', function () {
                let fuel_id = $(this).attr('id')
                let name = $(this).attr('name')
                let price = $(this).attr('price')
                let term = $(this).attr('term')
                if (fuel_id) {
                    $('#fuel_id').val(fuel_id)
                    $('#name').val(name)
                    $('#price').val(price)
                    $('#term').val(term)
                } else {
                    $('#fuel_id').val("")
                    $('#name').val("")
                    $('#price').val("")
                    $('#term').val("")
                }

                $('#addEditFuelPriceModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditFuelPriceForm').submit();
                })
            });

            $('.saveFuelPrice').click(function () {
                $('#addEditFuelPriceForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let fuel_id = $(this).attr('id');
                let url = "{{ route('vehicles.fuel_price.destroy',':id') }}"
                url = url.replace(':id', fuel_id);
                $('#deleteFuelPriceForm').attr('action', url)
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
                        $('#deleteFuelPriceForm').submit();
                    } else {
                        swal(
                            'You cancelled!',
                            'Your record is safe now.',
                            'error',
                        )
                    }
                })
            })


        });


    </script>
@endsection


