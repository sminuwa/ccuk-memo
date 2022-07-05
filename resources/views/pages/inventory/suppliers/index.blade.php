@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="#{{--{{ route('inventory.items.create') }}--}}" class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add supplier
                    </a>
                </div>
                <h4 class="table-header mb-4">Manage suppliers</h4>
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
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->code }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->address }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $supplier->id }}"
                                       code="{{ $supplier->code }}"
                                       name="{{ $supplier->name }}"
                                       email="{{ $supplier->email }}"
                                       phone="{{ $supplier->phone }}"
                                       address="{{ $supplier->address }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $supplier->id }}"><i class="las la-trash"></i></a>
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
    <div id="addEditSupplierModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditSupplierForm" method="post" action="{{ route('inventory.suppliers.store') }}">
                        @csrf
                        <input type="hidden" value="" name="supplier_id" id="supplier_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea type="text" name="address" id="address" class="form-control" placeholder="Address"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveSupplier">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteSupplierForm">
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
                let supplier_id = $(this).attr('id')
                let code = $(this).attr('code');
                let name = $(this).attr('name');
                let email = $(this).attr('email');
                let phone = $(this).attr('phone');
                let address = $(this).attr('address');
                if (supplier_id) {
                    $('#supplier_id').val(supplier_id)
                    $('#code').val(code)
                    $('#name').val(name)
                    $('#email').val(email)
                    $('#phone').val(phone)
                    $('#address').val(address)
                } else {
                    $('#supplier_id').val("")
                    $('#code').val("")
                    $('#name').val('')
                    $('#email').val('')
                    $('#phone').val('')
                    $('#address').val('')
                }

                $('#addEditSupplierModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditSupplierForm').submit();
                })
            });

            $('.saveSupplier').click(function () {
                $('#addEditSupplierForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let item_id = $(this).attr('id');
                let url = "{{ route('inventory.suppliers.destroy',':id') }}"
                url = url.replace(':id', item_id);
                $('#deleteSupplierForm').attr('action', url)
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
                        $('#deleteSupplierForm').submit();
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
