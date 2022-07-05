@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="#{{--{{ route('inventory.items.create') }}--}}" class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add unit
                    </a>
                </div>
                <h4 class="table-header mb-4">Manage Items unit</h4>
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
                            <th>Code</th>
                            <th>Base Unit</th>
                            <th>Formula</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($units as $unit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>{{ $unit->code }}</td>
                                <td>{{ $unit->base_unit }}</td>
                                <td>
                                    {{ $unit->formula() }}
                                </td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $unit->id }}"
                                       name="{{ $unit->name }}"
                                       code="{{ $unit->code }}"
                                       base_unit="{{ $unit->base_unit }}"
                                       operator="{{ $unit->operator }}"
                                       operation_value="{{ $unit->operation_value }}"
                                    ><i class="las la-edit"></i></a>
                                    @if($unit->base_unit != null)
                                        <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                           id="{{ $unit->id }}"><i class="las la-trash"></i></a>
                                    @endif
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
    <div id="addEditUnitModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Item units</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditUnitForm" method="post" action="{{ route('inventory.configurations.units.store') }}">
                        @csrf
                        <input type="hidden" value="" name="category_id" id="category_id"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Unit Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Unit Code" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="base_unit">Base Unit</label>
                                    <select type="text" name="base_unit" id="base_unit" class="form-control">
                                        <option></option>
                                        <option>Metre</option>
                                        <option>Piece</option>
                                        <option>Kilogram</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="operator">Operator</label>
                                    <select type="text" name="operator" id="operator" class="form-control">
                                        <option></option>
                                        <option>Multiply</option>
                                        <option>Divide</option>
                                        <option>Plus</option>
                                        <option>Minus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="operation_value">Operation value</label>
                                    <input type="number" name="operation_value" id="operation_value" class="form-control" placeholder="Operation values">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>Information goes here</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveUnit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteUnitForm">
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
                let unit_id = $(this).attr('id')
                let name = $(this).attr('name');
                let code = $(this).attr('code');
                let base_unit = $(this).attr('base_unit');
                let operator = $(this).attr('operator');
                let operation_value = $(this).attr('operation_value');
                if (unit_id) {
                    $('#unit_id').val(unit_id)
                    $('#name').val(name)
                    $('#code').val(code)
                    $('#base_unit').val(base_unit)
                    $('#operator').val(operator)
                    $('#operation_value').val(operation_value)
                } else {
                    $('#unit_id').val("")
                    $('#name').val("")
                    $('#code').val("")
                    $('#base_unit').val("")
                    $('#operator').val("")
                    $('#operation_value').val("")
                }

                $('#addEditUnitModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditUnitForm').submit();
                })
            });

            $('.saveUnit').click(function () {
                $('#addEditUnitForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let item_id = $(this).attr('id');
                let url = "{{ route('inventory.configurations.units.destroy',':id') }}"
                url = url.replace(':id', item_id);
                $('#deleteUnitForm').attr('action', url)
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
                        $('#deleteUnitForm').submit();
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
