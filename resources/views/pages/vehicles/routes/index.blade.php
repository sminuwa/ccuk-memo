@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Location
                    </button>
                </div>
                <h4 class="table-header mb-4">Manage Location</h4>
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
                            <th>Direction</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routes as $route)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $route->name }}</td>
                                <td>{{ $route->direction }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $route->id }}"
                                       name="{{ $route->name }}"
                                       direction="{{ $route->direction }}"
                                    >
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{$route->id}}">
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
    <div id="addEditRouteModal" class="modal animated {{ modalAnimation() }}" role="dialog">
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
                    <form id="addEditRouteForm" method="post" action="{{ route('vehicles.route.store') }}">
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
                    <button type="button" class="btn btn-primary saveRoute">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteRouteForm">
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

                $('#addEditRouteModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditRouteForm').submit();
                })
            });

            $('.saveRoute').click(function () {
                $('#addEditRouteForm').submit();
            })



            $('.widget-content .warning.delete').on('click', function () {
                let route_id = $(this).attr('id');
                let url = "{{ route('vehicles.route.destroy',':id') }}"
                url = url.replace(':id', route_id);
                $('#deleteRouteForm').attr('action', url)
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
                        $('#deleteRouteForm').submit();
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



