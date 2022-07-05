@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Enroll staff
                    </button>
                </div>
                <h4 class="table-header mb-4">Manage Payroll</h4>
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
                            <th>P.No.</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Account</th>
                            <th class="no-content"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="@if($user->status == 'Suspended') bg-warning @endif">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->details()->personnel_number }}</td>
                                <td>
                                    <a href="{{ route('payroll.staff.show', $user->id) }}" class="text-secondary">
                                        {{ $user->completeName() }}
                                    </a>
                                </td>
                                <td>{{ $user->level ?? null }} / {{ $user->step ?? null }}</td>
                                <td>{{ $user->account_number }}</td>
                                <td class="text-right">
                                    <a href="#" title="Edit" class="font-20 text-primary edit"
                                       id="{{ $user->payroll_user_id }}"
                                       user_id="{{ $user->id }}"
                                       user_name="{{ $user->fullName() }}"
                                       level="{{ $user->level }}"
                                       step="{{ $user->step }}"
                                       confirmation="{{ $user->confirmation }}"
                                       status="{{ $user->status }}"
                                       account="{{ $user->account_number }}"
                                       bank="{{ $user->bank }}"
                                    ><i class="las la-edit"></i></a>
                                    <a href="#" title="Delete" class="font-20 text-danger warning delete"
                                       id="{{ $user->payroll_user_id }}"><i class="las la-trash"></i></a>
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
    <div id="addEditStaffModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditStaffForm" method="post" action="{{ route('payroll.staff.store') }}">
                        @csrf
                        <input type="hidden" value="" name="payroll_user_id" id="payroll_user_id"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Staff</label>
                                    <select name="user_id" id="user_id" class="form-control select2"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select name="level" id="level" class="form-control" required>
                                        <option></option>
                                        @for($i=1; $i<=20; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                        <option>A</option>
                                        <option>B</option>
                                        <option>C</option>
                                        <option>D</option>
                                        <option>E</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="step">Step</label>
                                    <select name="step" id="step" class="form-control" required>
                                        <option value=""></option>
                                        @for($i=1; $i<=20; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmation">Confirmation</label>
                                    <select name="confirmation" id="confirmation" class="form-control">
                                        <option></option>
                                        <option>Confirmed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" >
                                        <option>Active</option>
                                        <option>Suspended</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account">Account Number</label>
                                    <input type="number" name="account" id="account" class="form-control" placeholder="Account Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank">Bank Name</label>
                                    <select name="bank" id="bank" class="form-control">
                                        <option></option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}"> {{ $bank->name }} </option>
                                        @endforeach
                                    </select>
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


    <form action="" method="post" id="deleteStaffForm">
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
                let payroll_user_id = $(this).attr('id')
                let user_id = $(this).attr('user_id')
                let user_name = $(this).attr('user_name')
                let level = $(this).attr('level')
                let step = $(this).attr('step')
                let confirmation = $(this).attr('confirmation')
                let status = $(this).attr('status')
                let account = $(this).attr('account')
                let bank = $(this).attr('bank')
                if (payroll_user_id) {
                    $('#payroll_user_id').val(payroll_user_id)
                    $('#user_id').val(user_id)
                    $('#user_name').val(user_name)
                    $('#level').val(level)
                    $('#step').val(step)
                    $('#confirmation').val(confirmation)
                    $('#status').val(status)
                    $('#account').val(account)
                    $('#bank').val(bank)
                } else {
                    $('#payroll_user_id').val('')
                    $('#user_id').val('')
                    $('#user_name').val('')
                    $('#level').val('')
                    $('#step').val('')
                    $('#confirmation').val('')
                    $('#status').val('')
                    $('#account').val('')
                    $('#bank').val('')
                }

                $('#addEditStaffModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditLocationForm').submit();
                })
            });

            $('.saveStaff').click(function () {
                $('#addEditStaffForm').submit();
            })

            $(document).on('click','.delete', function () {
                let location_id = $(this).attr('id');
                let url = "{{ route('payroll.staff.destroy',':id') }}"
                url = url.replace(':id', location_id);
                $('#deleteStaffForm').attr('action', url)
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
                        $('#deleteStaffForm').submit();
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
