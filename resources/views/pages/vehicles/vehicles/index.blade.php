@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="#{{--{{ route('inventory.items.create') }}--}}" class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add vehicle
                    </a>
                </div>
                <h4 class="table-header mb-4">Manage vehicles</h4>
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Number</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicles as $vehicle)
                            <tr data-href="{{route('vehicles.show',$vehicle->id)}}" class="clickable-row @if($vehicle->status == 'inactive') bg-warning text-white @endif">
                                <td>{{$loop->index+1 }}</td>
                                <td>{{$vehicle->code }}</td>
                                <td>{{$vehicle->name }}</td>
                                <td>{{$vehicle->color }}</td>
                                <td>{{$vehicle->number }}</td>
                                <td class="text-right">
                                    <a title="Show" class="font-20 text-primary"
                                       href="{{route('vehicles.show',$vehicle->id)}}">
                                        <i class="las la-cog"></i>
                                    </a>
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{$vehicle->id}}"
                                    >
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{$vehicle->id}}">
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
    <div id="addEditVehicleModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditVehicleForm" method="post" action="{{ route('vehicles.store') }}">
                        @csrf
                        <input type="hidden" value="" name="route_id" id="route_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Route Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="direction">Direction</label>
                                    <input type="text" name="direction" id="direction" class="form-control" placeholder="Direction">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveVehicle">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteVehicleForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('body').on('click', '.edit, .add', function () {
                let route_id = $(this).attr('id')
                let name = $(this).attr('name')
                let direction = $(this).attr('direction')
                if (route_id) {
                    $('#route_id').val(route_id)
                    $('#name').val(name)
                    $('#direction').val(direction)
                } else {
                    $('#route_id').val("")
                    $('#name').val("")
                    $('#direction').val("")
                }

                $('#addEditVehicleModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditVehicleForm').submit();
                })
            });

            $('.saveVehicle').click(function () {
                $('#addEditVehicleForm').submit();
            })



            $('.widget-content .warning.delete').on('click', function () {
                let route_id = $(this).attr('id');
                let url = "{{ route('vehicles.destroy',':id') }}"
                url = url.replace(':id', route_id);
                $('#deleteVehicleForm').attr('action', url)
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
                        $('#deleteVehicleForm').submit();
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
