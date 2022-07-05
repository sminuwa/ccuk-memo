@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="#{{--{{ route('inventory.items.create') }}--}}" class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Item
                    </a>
                </div>
                <h4 class="table-header mb-4">Manage Inventory Items</h4>
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
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Alert Qty</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->alert_quantity }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $item->id }}"
                                       name="{{ $item->name }}"
                                       brand="{{ $item->brand }}"
                                       category_id="{{ $item->category->id }}"
                                       unit="{{ $item->unit }}"
                                       brand="{{ $item->brand }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $item->id }}"><i class="las la-trash"></i></a>
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
    <div id="addEditItemModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Inventory Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditItemForm" method="post" action="{{ route('inventory.configurations.items.store') }}">
                        @csrf
                        <input type="hidden" value="" name="item_id" id="item_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Item Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Item name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select type="text" name="category_id" id="category_id" class="form-control" required>
                                        <option value="">-- Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit of Item</label>
                                    <select type="text" name="unit" id="unit" class="form-control" required>
                                        <option value="">-- Unit --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->code }}">{{ $unit->name }} ({{ $unit->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" id="brand" class="form-control" placeholder="Brand">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alert_quantity">Alert Quantity</label>
                                    <input type="number" name="alert_quantity" id="alert_quantity" class="form-control" placeholder="Alert Quantity">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveItem">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deleteItemForm">
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
                let item_id = $(this).attr('id')
                let name = $(this).attr('name');
                let brand = $(this).attr('brand');
                let category_id = $(this).attr('category_id');
                let branch_id = $(this).attr('branch_id');
                let unit = $(this).attr('unit');
                let quantity = $(this).attr('quantity');
                let alert_quantity = $(this).attr('alert_quantity');
                let unit_price = $(this).attr('unit_price');
                if (item_id) {
                    $('#item_id').val(item_id)
                    $('#name').val(name)
                    $('#brand').val(brand)
                    $('#category_id').val(category_id)
                    $('#branch_id').val(branch_id)
                    $('#unit').val(unit)
                    $('#quantity').val(quantity)
                    $('#alert_quantity').val(alert_quantity)
                    $('#unit_price').val(unit_price)
                } else {
                    $('#item_id').val("")
                    $('#name').val("")
                    $('#brand').val("")
                    $('#category_id').val("")
                    $('#branch_id').val("")
                    $('#unit').val("")
                    $('#quantity').val("")
                    $('#alert_quantity').val("")
                    $('#unit_price').val("")
                }

                $('#addEditItemModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditItemForm').submit();
                })
            });

            $('.saveItem').click(function () {
                $('#addEditItemForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let item_id = $(this).attr('id');
                let url = "{{ route('inventory.configurations.items.destroy',':id') }}"
                url = url.replace(':id', item_id);
                $('#deleteItemForm').attr('action', url)
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
                        $('#deleteItemForm').submit();
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
