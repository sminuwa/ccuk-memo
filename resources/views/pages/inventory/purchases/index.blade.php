@extends('layouts.master')

@section('content')
    @php $user = auth()->user(); @endphp
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <a href="#{{--{{ route('inventory.items.create') }}--}}" class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add purchase
                    </a>
                </div>
                <h4 class="table-header mb-4">Manage purchases</h4>
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
                            <th>Item</th>
                            <th>Batch No.</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>EXP Date</th>
                            <th>SUP Date</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $purchase->item->name }}</td>
                                <td>{{ $purchase->batch_number }}</td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>{{ $purchase->unit_price }}</td>
                                <td>{{ date('m-d-Y', strtotime($purchase->expiry)) }}</td>
                                <td>{{ date('m-d-Y', strtotime($purchase->date)) }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $purchase->id }}"
                                       branch_id="{{ $purchase->branch->id }}"
                                       item_id="{{ $purchase->item->id }}"
                                       batch_number="{{ $purchase->batch_number }}"
                                       quantity="{{ $purchase->quantity }}"
                                       unit_price="{{ $purchase->unit_price }}"
                                       expiry="{{ date('m-d-Y', strtotime($purchase->expiry)) }}"
                                       date="{{ date('m-d-Y', strtotime($purchase->date)) }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $purchase->id }}"><i class="las la-trash"></i></a>
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
    <div id="addEditPurchaseModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Inventory purchases</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditPurchaseForm" method="post" action="{{ route('inventory.purchases.store') }}">
                        @csrf
                        <input type="hidden" value="" name="purchase_id" id="purchase_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Branch Name</label>
                                    <select type="text" name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">-- Branch --</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" @if($user->branch()->id == $branch->id) selected  @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Item Name</label>
                                    <select type="text" name="item_id" id="item_id" class="form-control" required>
                                        <option value="">-- Item --</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch_number">Batch Number</label>
                                    <input type="text" name="batch_number" id="batch_number" class="form-control" placeholder="Batch Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_price">Unit Price</label>
                                    <input type="number" name="unit_price" id="unit_price" class="form-control" placeholder="Unit Price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Purchase Date</label>
                                    <input type="text" name="date" id="date" class="form-control latpickr flatpickr-input active" placeholder="Purchase Date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry">Item Expiry Date</label>
                                    <input type="text" name="expiry" id="expiry" class="form-control latpickr flatpickr-input active" placeholder="Expiry Date">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary savePurchase">Save</button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="post" id="deletePurchaseForm">
        @csrf
        {{ method_field('DELETE') }}
    </form>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $("#example").flatpickr();

            $('body').on('click', '.edit, .add', function () {
                let purchase_id = $(this).attr('id');
                let branch_id = $(this).attr('branch_id')
                let item_id = $(this).attr('item_id')
                let batch_number = $(this).attr('batch_number')
                let quantity = $(this).attr('quantity')
                let unit_price = $(this).attr('unit_price')
                let expiry = $(this).attr('expiry')
                let date = $(this).attr('date')
                if (purchase_id) {
                    $('#purchase_id').val(purchase_id)
                    $('#branch_id').val(branch_id)
                    $('#item_id').val(item_id)
                    $('#batch_number').val(batch_number)
                    $('#quantity').val(quantity)
                    $('#unit_price').val(unit_price)
                    $('#expiry').val(expiry)
                    $('#date').val(date)
                } else {
                    $('#purchase_id').val("")
                    $('#branch_id').val("")
                    $('#item_id').val("")
                    $('#batch_number').val("")
                    $('#quantity').val("")
                    $('#unit_price').val("")
                    $('#expiry').val("")
                    $('#date').val("")
                }

                $('#addEditPurchaseModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditPurchaseForm').submit();
                })
            });

            $('.savePurchase').click(function () {
                $('#addEditPurchaseForm').submit();
            })

            $('.widget-content .warning.delete').on('click', function () {
                let item_id = $(this).attr('id');
                let url = "{{ route('inventory.purchases.destroy',':id') }}"
                url = url.replace(':id', item_id);
                $('#deletePurchaseForm').attr('action', url)
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
                        $('#deletePurchaseForm').submit();
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
