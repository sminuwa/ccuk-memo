@extends('layouts.master')

@section('content')
    @include('pages.hr.menus')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="media">
                            <div class="mr-3">
                                <img src="{{ myAsset('master/assets/img/profile-16.jpg') }}" alt="" class="avatar-md rounded-circle img-thumbnail">
                            </div>
                            <div class="align-self-center media-body">
                                <div class="text-muted">
                                    <h5 class="mb-1">{{ $unit->name }}</h5>
                                    <p class="mb-1">CAPITAL CITY UNIVERSITY, KANO</p>
                                    {{--<p class="mb-0">Human Resource Section</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="align-self-center col-lg-3">
                        <div class="text-lg-center mt-4 mt-lg-0">
                            <div class="row">
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Staff</p>
                                        <h5 class="mb-0">{{ $unit->staff->count() }}</h5>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Tasks</p>
                                        <h5 class="mb-0">{{ $unit->hr_mapping->count() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right">
                        <button class="btn btn-primary bg-gradient-primary addStaff">
                            <span class="las la-user-plus"></span> Add staff
                        </button>
                        <button class="btn btn-primary bg-gradient-primary addTask">
                            <span class="las la-clock"></span> Add task
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <h4 class="table-header mb-4 text-center text-uppercase">{{ $unit->name }}</h4>

            </div>
        </div>--}}

    </div>
    <div class="row">
        @if(session()->has('success'))
            <div class="alert alert-success"> {{ session('success') }}</div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger"> {{ session('error') }}</div>
        @endif

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 layout-spacing">
            <div class="widget">
                <h4 class="title">List of tasks</h4>
                <div class="table-responsive mb-4">
                    <table class="datatable table" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Point</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mappings as $mapping)
                            <tr class="bs-tooltip" data-placement="right" title="{{ $mapping->task->description }}">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $mapping->task->code }}</td>
                                <td>{{ $mapping->task->name }}</td>
                                <td>{{ $mapping->task->point }}</td>
                                <td class="text-right">
                                    <a href="{{ route('hr.tasks.mappings.unit', $mapping->id) }}" title="Unit Profile" class="font-20 text-danger "><i class="las la-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 layout-spacing">
                <div class="widget bg-gradient-warning">
                    <div class="f-100">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="text-white">
                                    <h5 class="text-white">Pending Tasks !</h5>
                                    <p class="blink_me text-white mt-1">In progress</p>
                                    <ul class="pl-3 mb-0">
                                        <li class="py-1">Repair printers</li>
                                        <li class="py-1">1,000,000 Naira sell target</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="align-self-end col-md-5">
                                <img src="{{ myAsset('master/assets/img/dashboard-image-uw.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endSection

@section('modals')
    <div id="addTaskModal" class="modal animated {{ modalAnimation() }}" role="dialog">
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
                    <form id="addEditTaskForm" method="post" action="{{ route('hr.tasks.store') }}">
                        @csrf
                        <input type="hidden" value="" name="task_id" id="task_id"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Task Code">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Task Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="point">Point</label>
                                    <input type="number" name="point" id="point" class="form-control" placeholder="Task Point">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">Duration (in hours)</label>
                                    <input type="number" name="duration" id="duration" class="form-control" placeholder="Task Duration">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="ripple-checkbox-primary">
                                        <input checked class="inp-cbx" id="cbx" type="checkbox" style="display: none">
                                        <label class="cbx" for="cbx">
                                        <span>
                                            <svg width="12px" height="10px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                            <span class="text-light-black">Active</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveTask">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteTaskForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $(document).on('click', '.addTask', function(){
                $("#addTaskModal").modal();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('hr.tasks.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteTaskForm').attr('action', url)
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
                        $('#deleteTaskForm').submit();
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
