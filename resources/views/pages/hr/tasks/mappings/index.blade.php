@extends('layouts.master')

@section('content')
    @include('pages.hr.menus')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add task
                    </button>
                </div>
                <h4 class="table-header mb-4">Manage tasks repository</h4>
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
                            <th>Tasks</th>
                            <th>Staff</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branches as $branch)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $branch->code }}</td>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->hr_mapping->count() }}</td>
                                <td>{{ $branch->staff->count() }}</td>
                                <td class="text-right">
                                    <a href="{{ route('hr.tasks.mappings.unit', $branch->id) }}" title="Unit Profile" class="font-20 text-primary"><i class="las la-cog"></i></a>

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
    <div id="addEditTaskModal" class="modal animated {{ modalAnimation() }}" role="dialog">
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

            $(document).on('click', '.edit, .add', function () {
                let task_id = $(this).attr('id')
                let code = $(this).attr('code')
                let name = $(this).attr('name')
                let point = $(this).attr('point')
                let duration = $(this).attr('duration')
                let description = $(this).attr('description')
                let status = $(this).attr('status')
                if (task_id) {
                    $('#task_id').val(task_id)
                    $('#code').val(code)
                    $('#name').val(name)
                    $('#point').val(point)
                    $('#duration').val(duration)
                    $('#description').val(description)
                    if(status === 1){
                        $( "#status" ).prop( "checked", true );
                    }else{
                        $( "#status" ).prop( "checked", false );
                    }
                } else {
                    $('#task_id').val("")
                    $('#code').val("")
                    $('#name').val("")
                    $('#point').val("")
                    $('#duration').val("")
                    $('#description').val("")
                    $('#status').val("")
                }

                $('#addEditTaskModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditTaskForm').submit();
                })
            });

            $('.saveTask').click(function () {
                $('#addEditTaskForm').submit();
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
