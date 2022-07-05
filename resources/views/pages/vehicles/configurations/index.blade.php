@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Configuration
                    </button>
                </div>
                <h4 class="table-header mb-4">General Vehicle Configurations</h4>
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
                            <th>Value</th>
                            <th>Type</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($configurations as $config)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $config->name }}</td>
                                <td>{{ $config->value }}</td>
                                <td>{{ $config->type }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $config->id }}"
                                       config_name="{{ $config->name }}"
                                       config_value="{{ $config->value }}"
                                       config_type="{{ $config->type }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $config->id }}"><i class="las la-trash"></i></a>
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
    <div id="addEditConfigurationModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Configuration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditConfigurationForm" method="post" action="{{ route('vehicles.configurations.store') }}">
                        @csrf
                        <input type="hidden" value="" name="configuration_id" id="configuration_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Config Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value">Value</label>
                                    <input type="text" name="value" id="value" class="form-control"
                                           placeholder="Config Value">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type"> Type</label>
                                    <input type="text" name="type" id="type" class="form-control"
                                           placeholder="Config Type">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveConfiguration">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteConfigurationForm">
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
                let configuration_id = $(this).attr('id')
                let config_name = $(this).attr('config_name')
                let config_value = $(this).attr('config_value')
                let config_type = $(this).attr('config_type')
                if (configuration_id) {
                    $('#configuration_id').val(configuration_id)
                    $('#name').val(config_name)
                    $('#value').val(config_value)
                    $('#type').val(config_type)
                } else {
                    $('#configuration_id').val("")
                    $('#config_name').val("")
                    $('#config_value').val("")
                    $('#config_type').val("")
                }

                $('#addEditConfigurationModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditConfigurationForm').submit();
                })
            });

            $('.saveConfiguration').click(function () {
                $('#addEditConfigurationForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('vehicles.configurations.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteConfigurationForm').attr('action', url)
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
                        $('#deleteConfigurationForm').submit();
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
