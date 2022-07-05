@extends('layouts.master')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6 text-center">
                <a href="#" class="btn btn-primary">
                    <i class="las la-plus-circle"></i> Regular
                </a>
                <a href="#" class="btn btn-primary">
                    <i class="las la-plus-circle"></i> Others
                </a>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="float-right">
                    <button class="btn btn-primary add">
                        <i class="las la-plus-circle"></i> Add structure
                    </button>
                </div>
                <h4 class="table-header mb-4">Salary structure</h4>
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{ session('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger"> {{ session('error') }}</div>
                @endif

                <div id="toggleAccordionWithIconRotate" class="basic-accordion-icon rotate">
                    @foreach($structures as $structure)
                    <div class="card">
                        <div class="card-header" id="basicAccordionIconheadingRotateOne">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="@if($loop->first) @else collapsed @endif" data-toggle="collapse" data-target="#basicAccordionIconRotateOne{{ $structure->level }}" aria-expanded="true" aria-controls="basicAccordionIconRotateOne">
                                    <i class="las la-money-bill font-20"></i> Salary structure Level #{{ $structure->level }}  <div class="icons"><i class="las la-angle-up has-rotate"></i></div>
                                </div>
                            </section>
                        </div>
                        <div id="basicAccordionIconRotateOne{{ $structure->level }}" class="collapse @if($loop->first) show @else @endif" aria-labelledby="basicAccordionIconheadingRotateOne" data-parent="#toggleAccordionWithIconRotate">
                            <div class="card-body">
{{--                                <h4 class="mb-4">Salary structure Level #{{ $structure->level }}</h4>--}}
                                <div class="row">
                                    @foreach($structure->structure as $strt)
                                        @php $total = $takeHom = $totalDeduction = 0; @endphp
                                        <div class="col-lg-12 col-md-12 col-sm-12 p-3">
                                            <div class="text-info">
                                                <div style="float:right">
                                                    <button class="btn btn-default bg-gradient-default btn-sm add"
                                                        level="{{ $structure->level }}"
                                                        step="{{ $strt->step }}">
                                                        Add
                                                    </button>
                                                </div>
                                                Level {{ $structure->level }} / {{ $strt->step }}
                                            </div>

                                            <table class="table table-sm mb-0">
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Type</th>
                                                    <th>Annually</th>
                                                    <th>Monthly</th>
                                                    <th></th>
                                                </tr>
                                                <tbody>
                                                @foreach($strt->items as $item)
                                                    @if($item->type == "Allowance" || $item->type== 'Basic')
                                                    <tr>
                                                        <th scope="row">{{ $item->name }}</th>
                                                        <td>
                                                            {{ $item->type }}
                                                        </td>
                                                        <td class="y_amount" amount="{{ number_format($item->amount, 2) }}">
                                                            {{ number_format($item->amount, 2) }} <i class="fa fa-pencil"></i>
                                                        </td>
                                                        <td class="m_amount" amount="{{ number_format($item->amount/12, 2) }}">
                                                            {{ number_format($item->amount/12, 2) }}
                                                        </td>
                                                        <td class="text-right">
                                                            <button class="btn btn-success px-2 py-1 bg-gradient-success btn-sm edit"
                                                                id="{{ $item->id }}"
                                                                item_id="{{ $item->item_id }}"
                                                                amount="{{ $item->amount }}"
                                                                type="{{ $item->type }}"
                                                                level="{{ $item->level }}"
                                                                step="{{ $item->step }}">
                                                                <i class="las la-edit"></i>
                                                            </button>
                                                            <button class="btn btn-danger px-2 py-1 bg-gradient-danger btn-sm delete"
                                                                    id="{{ $item->id }}">
                                                                <i class="las la-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @php $total+=$item->amount @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <th scope="row" class="text-warning">TOTAL</th>
                                                    <td></td>
                                                    <td class="text-warning">
                                                        {{ number_format($total, 2) }}
                                                    </td>
                                                    <td class="text-warning">
                                                        {{ number_format($total/12, 2) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @foreach($strt->items as $item)
                                                    @if($item->type == "Deduction")
                                                        <tr>
                                                            <th scope="row">{{ $item->name }}</th>
                                                            <td>
                                                                {{ $item->type }}
                                                            </td>
                                                            <td>
                                                                {{ number_format(($item->amount), 2) }}
                                                            </td>
                                                            <td>
                                                                {{ number_format(($item->amount)/12, 2) }}
                                                            </td>
                                                            <td class="text-right">
                                                                <button class="btn btn-success px-2 py-1 bg-gradient-success btn-sm edit"
                                                                        id="{{ $item->id }}"
                                                                        item_id="{{ $item->item_id }}"
                                                                        amount="{{ $item->amount }}"
                                                                        type="{{ $item->type }}"
                                                                        level="{{ $item->level }}"
                                                                        step="{{ $item->step }}">
                                                                    <i class="las la-edit"></i>
                                                                </button>
                                                                <button class="btn btn-danger px-2 py-1 bg-gradient-danger btn-sm delete"
                                                                        id="{{ $item->id }}">
                                                                    <i class="las la-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @php $totalDeduction+=$item->amount @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <th scope="row" class="text-success">TAKE HOME</th>
                                                    <td></td>
                                                    <td class="text-success">
                                                        {{ number_format(($total-$totalDeduction), 2) }}
                                                    </td>
                                                    <td class="text-success">
                                                        {{ number_format(($total-$totalDeduction)/12, 2) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <hr class="shadow">
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endSection

@section('modals')
    <div id="addEditSalaryModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog {{ modalClasses() }}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Salary Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addEditSalaryForm" method="post" action="{{ route('payroll.salary.structure.store') }}">
                        @csrf
                        <input type="hidden" value="" name="item_id" id="item_id"/>
                        <div class="row">
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
                                        <option>F</option>
                                        <option>G</option>
                                        <option>H</option>
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
                                    <label for="name">Item</label>
                                    <select type="text" name="_item_id" id="_item_id" class="form-control" required>
                                        <option></option>
                                        @foreach(\App\Models\PayrollItem::all() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Type</label>
                                    <select type="text" name="type" id="type" class="form-control" required>
                                        <option value=""></option>
                                        <option value="Basic">Basic</option>
                                        <option value="Allowance">Allowance</option>
                                        <option value="Deduction">Deduction/Tax</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-primary saveSalary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div id="deleteSalaryModal" class="modal animated {{ modalAnimation() }}" role="dialog">
        <div class="modal-dialog modal-dialog-centered {{--{{ modalClasses() }}--}}">
            <!-- Modal content-->
            <div class="modal-content {{ modalPadding() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure you want delete this record?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="post" id="deleteSalaryForm">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="button" class="btn btn-danger deleteSalary">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.edit, .add', function(){
                let item_id = $(this).attr('id')
                let _item_id = $(this).attr('item_id')
                let level = $(this).attr('level')
                let step = $(this).attr('step')
                let type = $(this).attr('type')
                let amount = $(this).attr('amount')
                if (item_id) {
                    $('#item_id').val(item_id)
                    $('#_item_id').val(_item_id)
                    $('#level').val(level)
                    $('#step').val(step)
                    $('#type').val(type)
                    $('#amount').val(amount)
                }else if(level){
                    $('#level').val(level)
                    $('#step').val(step)
                    $('#item_id').val('')
                    $('#_item_id').val('')
                    $('#type').val('')
                    $('#amount').val('')
                } else {
                    $('#item_id').val('')
                    $('#_item_id').val('')
                    $('#level').val('')
                    $('#step').val('')
                    $('#type').val('')
                    $('#amount').val('')
                }

                $('#addEditSalaryModal').modal();
                $('.btnSave').click(function () {
                    $('#addEditSalaryForm').submit();
                })
            })

            $('.saveSalary').click(function () {
                $('#addEditSalaryForm').submit();
            })



            $('.delete').on('click', function () {
                let structure_id = $(this).attr('id');
                let url = "{{ route('payroll.salary.structure.destroy',':id') }}"
                url = url.replace(':id', structure_id);

                $('#deleteSalaryForm').attr('action', url)

                $('#deleteSalaryModal').modal();
            })

            $('.deleteSalary').click(function () {
                $('#deleteSalaryForm').submit();
            })


        });


    </script>
@endsection
