@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Location route
                    </button>
                </div>
                <h4 class="table-header mb-4">Location Route Configurations</h4>
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
                            <th>From</th>
                            <th>To</th>
                            <th>Route</th>
                            <th>Distance</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locationRoutes as $locationRoute)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $locationRoute->locationFrom?->name }}</td>
                                <td>{{ $locationRoute->locationTo?->name }}</td>
                                <td>{{ $locationRoute->route?->name }}</td>
                                <td>{{ $locationRoute->distance }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $locationRoute->id }}"
                                       location_from="{{ $locationRoute->locationFrom?->id }}"
                                       location_to="{{ $locationRoute->locationTo?->id }}"
                                       route="{{ $locationRoute->route?->id }}"
                                       distance="{{ $locationRoute->distance }}"
                                    >
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $locationRoute->id }}" >
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
    <div id="addEditLocationRouteModal" class="modal animated {{ modalAnimation() }}" role="dialog">
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
                    <form id="addEditLocationRouteForm" method="post" action="{{ route('vehicles.location_route.store') }}">
                        @csrf
                        <input type="hidden" value="" name="location_route_id" id="location_route_id"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location_from">From</label>
                                    <select type="text" name="location_from" id="location_from" class="form-control" required>
                                        <option value="">-- From --</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location_to">To</label>
                                    <select type="text" name="location_to" id="location_to" class="form-control" required>
                                        <option value="">-- To --</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="route_id">Route</label>
                                    <select type="text" name="route_id" id="route_id" class="form-control" required>
                                        <option value="">-- Route --</option>
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}">{{ $route->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direction">Distance</label>
                                    <input type="text" name="distance" id="distance" class="form-control" placeholder="Distance (eg. 120km)">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveLocationRoute">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteLocationRouteForm">
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
                let location_route_id = $(this).attr('id')
                let location_from = $(this).attr('location_from')
                let location_to = $(this).attr('location_to')
                let distance = $(this).attr('distance')
                if (route_id) {
                    $('#location_route_id').val(location_route_id)
                    $('#location_from').val(location_from)
                    $('#location_to').val(location_to)
                    $('#distance').val(distance)
                } else {
                    $('#location_route_id').val("")
                    $('#location_from').val("")
                    $('#location_to').val("")
                    $('#distance').val("")
                }

                $('#addEditLocationRouteModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditLocationRouteForm').submit();
                })
            });

            $('.saveLocationRoute').click(function () {
                $('#addEditLocationRouteForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let location_route_id = $(this).attr('id');
                let url = "{{ route('vehicles.location_route.destroy',':id') }}"
                url = url.replace(':id', location_route_id);
                $('#deleteLocationRouteForm').attr('action', url)
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
                        $('#deleteLocationRouteForm').submit();
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

