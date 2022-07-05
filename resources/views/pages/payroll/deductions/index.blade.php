@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right mb-lg-4">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add Deduction
                    </button>
                </div>
                <h4 class="table-header mb-4">Manage Deductions</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div class="table-responsive mt-4 mb-4">
                    <table class="export-data table" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Staff</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>Installment</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->fullName() }}</td>
                                <td>{{ number_format($user->amount, 2) }}</td>
                                <td>{{ date('F, Y', strtotime($user->start_date)) }}</td>
                                <td>{{ $user->deducted }}/{{ $user->installment }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                        id="{{ $user->payroll_deduction_id }}"
                                        item_id="{{ $user->item_id }}"
                                        amount="{{ $user->amount }}"
                                        installment="{{ $user->installment }}"
                                        start_date="{{ $user->start_date }}"
                                        description="{{ $user->description }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                        id="{{ $user->payroll_deduction_id }}"
                                    ><i class="las la-trash"></i></a>
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
    <div id="addEditDeductionModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Deduction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditDeductionForm" method="post" action="{{ route('payroll.deductions.store') }}">
                        @csrf
                        <input type="hidden" value="" name="payroll_deduction_id" id="payroll_deduction_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Staff</label>
                                    <select name="user_id" id="user_id" class="form-control select2"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_id">Item</label>
                                    <select name="item_id" id="item_id" class="form-control" required>
                                        <option></option>
                                        @php $items = \App\Models\PayrollItem::all(); @endphp
                                        @foreach($items as $item)
                                            <option value="{{ $item->id}}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount (Monthly)</label>
                                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount (Monthly)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="installment">Installment</label>
                                    <input type="number" name="installment" id="installment" class="form-control" placeholder="Installment">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description (Optional)</label>
                                    <textarea type="date" name="description" id="description" class="form-control" placeholder="Description (Optional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveStaff">Save</button>
                </div>
            </div>
        </div>
    </div>


    <form action="" method="post" id="deleteDeductionForm">
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
                let payroll_deduction_id = $(this).attr('id')
                let item_id = $(this).attr('item_id')
                let amount = $(this).attr('amount')
                let installment = $(this).attr('installment')
                let start_date = $(this).attr('start_date')
                let description = $(this).attr('description')
                if (payroll_deduction_id) {
                    $('#payroll_deduction_id').val(payroll_deduction_id)
                    $('#item_id').val(item_id)
                    $('#amount').val(amount)
                    $('#installment').val(installment)
                    $('#start_date').val(start_date)
                    $('#description').val(description)
                } else {
                    $('#payroll_deduction_id').val("")
                    $('#item_id').val("")
                    $('#amount').val("")
                    $('#installment').val("")
                    $('#start_date').val("")
                    $('#description').val("")
                }

                $('#addEditDeductionModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditLocationForm').submit();
                })
            });

            $('.saveStaff').click(function () {
                $('#addEditDeductionForm').submit();
            })

            $(document).on('click','.delete', function () {
                let payroll_deduction_id = $(this).attr('id');
                let url = "{{ route('payroll.deductions.destroy',':id') }}"
                url = url.replace(':id', payroll_deduction_id);
                $('#deleteDeductionForm').attr('action', url)
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
                        $('#deleteDeductionForm').submit();
                    } else {
                        swal(
                            'You cancelled!',
                            'Your record is safe now.',
                            'error',
                        )
                    }
                })
            })

            selectTwo('select2')
            function selectTwo(param) {
                $('.' + param).select2({
                    placeholder: "Search name",
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        type: 'GET',
                        dataType: 'json',
                        delay: 250,
                        url: '{{ route('users.search.user','all') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public'
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            }
                        }
                        , cache: true
                    }
                });
            }
        });


    </script>
@endsection

