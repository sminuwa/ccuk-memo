@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card ">
                <div class="card-header">
                    <div style="float: right;">
                        <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                            <span class="fa fa-close"></span> Close
                        </a>
                    </div>
                    <h5 class="card-title">Raise a Form</h5>
                </div>
                <div class="card-body ">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form class="memo-form" action="{{ route('memos.store') }}"
                          onsubmit="return confirm('Are you sure you want to send this memo?')" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="Form">
                        <input type="hidden" name="draft" class="draft-box">
                        <input type="hidden" name="draft_id" class="draft-id">
                        <div class="form-group">
                            <label>Send To:</label>
                            <select class="form-control mySelect3" name="sendto"></select>
                        </div>
                        <div class="form-group">
                            <label>Subject:</label>
                            <select type="text" class="form-control subject" placeholder="Subject" name="title"
                                    style="height: auto;padding: 2px 10px;">
                                <option>--</option>
                                <option>Adjustment Approval</option>
                                <option>Authority To Pay</option>
                                <option>Cash Advance</option>
                                <option>Housing Allowance</option>
                                <option>Meal Allowance</option>
                                <option>Off Days Allowance</option>
                                <option>Recharge Card</option>
                                <option>Weekly Entertainment</option>
                                <option>Diesel Request</option>
                                <option>Dispatch Truck</option>
                                <option>Carriage Bill</option>
                            </select>
                        </div>

                        <div>
                            <div class="form-group" id="form-body">

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Attachment Name</label>
                            <div id="attachment">
                                <div class="row" id="item1">
                                    <div class="col-md-6" style="padding-bottom:2px;">
                                        <input type="text" name="attachment_name[]" class="form-control"
                                               placeholder="Attachment Name (if any)"
                                               style="padding: 2px 10px;">
                                    </div>
                                    <div class="col-md-6" style="padding-bottom:2px;">
                                        <input type="file" name="attachment[]" style="opacity: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:;" class="btn btn-success btn-sm add-attachment">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Copy To:</label>
                            <select class="form-control mySelect2" multiple="multiple" name="copy[]"></select>
                            <span class="autocomplete-select"></span>
                        </div>
                    </form>
                </div>
                <div class="card-footer ">
                    <a class="btn btn-default btn-send" type="submit"><i class="fa fa-save"></i> Send </a>
                    <a name="draft" class="btn btn-info btn-draft"><i class="fa fa-clipboard"></i> Save as Draft </a>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>

    </style>
@endsection

@push('js')
    <script>
        // initSample();
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('ckeditor1', function (config) {
            config.toolbarGroups = [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                '/',
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ];
            config.height = 1000;
            config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Source,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,CreateDiv,Link,Unlink,Anchor,Image,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,About';
        });
    </script>

    <script>
        $(document).ready(function () {

            $('.subject').change(function () {
                if ($(this).val() === '{{ \App\Models\Memo::FORM_MEAL_ALLOWANCE }}') {
                    $('#form-body').html(meal_allowance_form).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3')
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_AUTHORITY_TO_PAY }}') {
                    $('#form-body').html(authority_to_pay).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_CASH_ADVANCE }}') {
                    $('#form-body').html(cash_advance).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_HOUSING_ALLOWANCE }}') {
                    $('#form-body').html(housing_allowance).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_RECHARGE_CARD }}') {
                    $('#form-body').html(recharge_card).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_OFF_DAYS_ALLOWANCE }}') {
                    $('#form-body').html(off_days_allowance).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_WEEKLY_ENTERTAINMENT }}') {
                    $('#form-body').html(weekly_entertainment).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_ADJUSTMENT_APPROVAL }}') {
                    $('#form-body').html(adjustment_approval).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else if ($(this).val() === '{{ \App\Models\Memo::FORM_DIESEL_REQUEST }}') {
                    $('#form-body').html(diesel_request).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                }else if ($(this).val() === '{{ \App\Models\Memo::FORM_DISPATCH_TRUCK }}') {
                    $('#form-body').html(dispatch_truck).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                    // selectTwoVehicle('mySelect3');
                }else if ($(this).val() === '{{ \App\Models\Memo::FORM_CARRIAGE_BILL }}') {
                    $('#form-body').html(carriage_bill).css({'border': '1px solid #ef8157', 'padding': '10px'});
                    selectTwo('mySelect3');
                } else {
                    $('#form-body').html('').css({'border': 'none', 'padding': '0'});
                }
            });

            $('body').on('click', '.others', function () {
                $('.select-section').html(department);
            });

            $('body').on('click', '.staff', function () {
                $('.select-section').html(staff);
                selectTwo('mySelect3')
            });

            let carriage_bill = `
                <div class="row">
                    <div class="col-md-7 select-section" style="padding-bottom:2px;">
                        <label>Driver's Name:</label>
                        <select type="text" name="driver" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;">
                        <label>Destination:</label>
                        <input type="text" name="destination" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Litre Requested:</label>
                        <input type="text" name="litre_requested" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Litre Issued:</label>
                        <input type="text" name="litre_issued" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Amount:</label>
                        <input type="text" name="amount" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Type:</label>
                        <input name="vehicle_type" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Reg/No:</label>
                        <input name="vehicle_no" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Transport Officer:</label>
                        <select type="text" name="officer" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Filling Station Name & Address:</label>
                        <textarea name="filling_station" class="form-control" style="padding: 2px 10px;"></textarea>
                    </div>
                </div>
            `;

            let dispatch_truck = `
                <div class="row">
                    <div class="col-md-7 select-section" style="padding-bottom:2px;">
                        <label>Driver's Name:</label>
                        <select type="text" name="driver" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>

                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Type:</label>
                        <input name="vehicle_type" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Reg/No:</label>
                        <input name="vehicle_no" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Transport Officer:</label>
                        <select type="text" name="officer" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Filling Station Name & Address:</label>
                        <textarea name="filling_station" class="form-control" style="padding: 2px 10px;"></textarea>
                    </div>
                </div>
            `;

            let diesel_request = `
                <div class="row">
                    <div class="col-md-7 select-section" style="padding-bottom:2px;">
                        <label>Driver's Name:</label>
                        <select type="text" name="driver" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;">
                        <label>Destination:</label>
                        <input type="text" name="destination" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Litre Requested:</label>
                        <input type="text" name="litre_requested" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Litre Issued:</label>
                        <input type="text" name="litre_issued" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Amount:</label>
                        <input type="text" name="amount" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Type:</label>
                        <input name="vehicle_type" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Vehicle Reg/No:</label>
                        <input name="vehicle_no" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Transport Officer:</label>
                        <select type="text" name="officer" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Filling Station Name & Address:</label>
                        <textarea name="filling_station" class="form-control" style="padding: 2px 10px;"></textarea>
                    </div>
                </div>
            `;

            let adjustment_approval = `
                <div class="row">
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Adjustment On:</label>
                        <input type="text" name="on" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-5 select-section" style="padding-bottom:2px;">
                        <label>Document Number:</label>
                        <input type="text" name="document_number" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4 select-section" style="padding-bottom:2px;">
                        <label>Document Type:</label>
                        <input type="text" name="document_type" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-3 select-section" style="padding-bottom:2px;">
                        <label>Document Date:</label>
                        <input type="text" name="document_date" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Reason for Adjustment:</label>
                        <textarea name="reason" class="form-control" style="padding: 2px 10px;"></textarea>
                    </div>
                </div>
            `;

            let authority_to_pay = `
                <div class="row">
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <div class="toggle" style="margin: 0;">
                            <input type="radio" name="by" value="staff" class="staff" id="staff-option" checked="checked"/>
                            <label for="staff-option">Staff</label>
                            <input type="radio" name="by" value="department" class="others" id="other-option"/>
                            <label for="other-option">Others</label>
                        </div>
                    </div>
                    <div class="col-md-7 select-section" style="padding-bottom:2px;">
                        <label>Beneficiary:</label>
                        <select type="text" name="name" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;">
                        <label>Amount:</label>
                        <input type="number" name="amount" id="authority-to-pay-amount" class="form-control" style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <label>Reason for Payment:</label>
                        <textarea name="reason" class="form-control" style="padding: 2px 10px;"></textarea>
                    </div>
                </div>
            `;

            let meal_allowance_form = `
                <div id="new-meal-allowance">
                    <div class="row" id="meal1">
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <label>Name</label>
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <label>Date</label>
                            <input type="text" name="date[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <label>Breakfast</label>
                            <input type="text" name="breakfast[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <label>Launch</label>
                            <input type="text" name="launch[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <label>Dinner</label>
                            <input type="text" name="dinner[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="javascript:;" class="btn btn-success btn-sm btn-add-row">
                            <i class="fa fa-plus"></i> Add Row
                        </a>
                    </div>
                </div>
            `;

            let cash_advance = `
                <div class="row">
                    <div class="col-md-12" style="padding-bottom:2px;">
                        <div class="toggle" style="margin: 0;">
                            <input type="radio" name="by" value="staff" class="staff" id="staff-option" checked="checked"/>
                            <label for="staff-option">Staff</label>
                            <input type="radio" name="by" value="department" class="others" id="other-option"/>
                            <label for="other-option">Others</label>
                        </div>
                    </div>
                    <div class="col-md-8 select-section" style="padding-bottom:2px;">
                        <label>Beneficiary:</label>
                        <select type="text" name="name" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <label>Touring:</label>
                        <input type="text" name="touring" id="authority-to-pay-amount" class="form-control" style="padding: 2px 10px;">
                    </div>
                </div>

                <div id="new-cash-advance-particular">
                    <div class="row" id="particular1">
                        <div class="col-md-8" style="padding-bottom:2px;">
                            @php $particulars = \App\Models\FormParticular::oldest('name')->get() @endphp
                <label>Particulars:</label>
                <select type="text" name="particulars[]" class="form-control" style="padding: 2px 10px;height:auto">
                    <option>--</option>
@foreach($particulars as $particular)
                <option>{{ $particular->name }}</option>
                                @endforeach
                </select>
            </div>
            <div class="col-md-4" style="padding-bottom:2px;">
                <label>Amount:</label>
                <input type="number" name="amount[]" id="authority-to-pay-amount" class="form-control" style="padding: 2px 10px;">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="javascript:;" class="btn btn-success btn-sm btn-add-cash-advance-row">
                <i class="fa fa-plus"></i> Add Particular
            </a>
        </div>
    </div>
`;

            let housing_allowance = `
                <div class="row">
                    <div class="col-md-7" style="padding-bottom:2px;">
                        <label>Name</label>
                        <select type="text" name="name" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control" style="padding: 2px 10px;">
                    </div>
                </div>
            `;

            let recharge_card = `
                <div id="new-recharge-card">
                    <div class="row" id="card1">
                        <div class="col-md-7" style="padding-bottom:2px;">
                            <label>Name</label>
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-5" style="padding-bottom:2px;">
                            <label>Amount</label>
                            <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="javascript:;" class="btn btn-success btn-sm btn-add-recharge-card-row">
                            <i class="fa fa-plus"></i> Add Row
                        </a>
                    </div>
                </div>
            `;

            let off_days_allowance = `
                <div id="new-off-days-allowance">
                    <div class="row" id="meal1">
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <label>Name</label>
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <label>Dates</label>
                            <input type="text" name="date[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <label>No of Days</label>
                            <input type="text" name="no_of_days[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <label>Amount</label>
                            <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="javascript:;" class="btn btn-success btn-sm btn-add-off-days-allowance-row">
                            <i class="fa fa-plus"></i> Add Row
                        </a>
                    </div>
                </div>
            `;

            let weekly_entertainment = `
                <div id="new-weekly-entertainment">
                    <div class="row" id="week1">
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <label>Item</label>
                            <input  type="text" name="item[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <label>Quantity</label>
                            <input type="text" name="quantity[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <label>Unit price</label>
                            <input type="text" name="price[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="javascript:;" class="btn btn-success btn-sm btn-add-weekly-entertainment-row">
                            <i class="fa fa-plus"></i> Add Row
                        </a>
                    </div>
                </div>
            `;

            let staff = `
                <div class="form-group">
                    <label>Beneficiary:</label>
                    <select type="text" name="name" class="form-control mySelect3" ></select>
                </div>
            `;
            let department = `
                <div class="form-group">
                    @php $departments = \App\Models\Department::all(); @endphp
                <label>Department:</label>
                <select class="form-control" name="department" id="department">
                    <option></option>
@foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                </select>
            </div>
`;
            let branch = `
                <div class="form-group">
                    @php $branches = \App\Models\Branch::all(); @endphp
                <label>Department:</label>
                <select class="form-control" name="branch" id="branch">
                    <option></option>
@foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                </select>
            </div>
`;

            $('.btn-send').click(function () {
                window.onbeforeunload = null;
                $('.draft-box').val('');
                $('.memo-form').submit();
            });

            $('.btn-draft').click(function () {
                window.onbeforeunload = null;
                $('.draft-box').val('draft');
                $('.memo-form').submit();
            });

            $('.draft').on('click', function () {
                window.onbeforeunload = function () {
                    return true;
                };
                $('.subject').val($(this).attr('title'));
                $('.draft-id').val($(this).attr('draft-id'));
                let oEditor = CKEDITOR.instances.ckeditor1;
                oEditor.insertHtml($(this).attr('body'));
                $("#draft-memos-modal").modal("toggle");
            });

            $('.btn-delete').click(function () {
                let draft = $(this).attr('draft-id');
                let url = "{{ route('memos.draft.destroy') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {draft_id: draft, _token: "{{ @csrf_token() }}"},
                    success: function (data) {
                        $('tr[data-id="' + draft + '"]').remove();
                    }
                });
            });

            $("#draft-memos").on("click", function () {
                $("#draft-memos-modal").modal("toggle");
            });

            let weekly = off_days = card = cash_num = form_num = num = 1;

            $('body').on('click', '.btn-add-weekly-entertainment-row', function () {
                weekly += 1;
                let data = `
                    <div class="row" id="week` + weekly + `">
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <input  type="text" name="item[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <input type="text" name="quantity[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <input type="text" name="price[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-1 text-right" style="padding-bottom:2px;">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num-week="` + weekly + `" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $('#new-weekly-entertainment').append(data);

                $('.btn-remove').click(function () {
                    $('#week' + $(this).data('num-week')).remove();
                    // alert($(this).data('num'))
                });

            });

            $('body').on('click', '.btn-add-off-days-allowance-row', function () {
                off_days += 1;
                let data = `
                    <div class="row" id="off` + off_days + `">
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <input type="text" name="date[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="no_of_days[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-1 text-right" style="padding-bottom:2px;">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num-off="` + off_days + `" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $('#new-off-days-allowance').append(data);
                selectTwo('mySelect3');
                $('.btn-remove').click(function () {
                    $('#off' + $(this).data('num-off')).remove();
                    // alert($(this).data('num'))
                });

            });

            $('body').on('click', '.btn-add-recharge-card-row', function () {
                card += 1;
                let data = `
                    <div class="row" id="card` + card + `">
                        <div class="col-md-7" style="padding-bottom:2px;">
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-1 text-right" style="padding-bottom:2px;">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num-card="` + card + `" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $('#new-recharge-card').append(data);
                selectTwo('mySelect3');
                $('.btn-remove').click(function () {
                    $('#card' + $(this).data('num-card')).remove();
                    // alert($(this).data('num'))
                });

            });

            $('body').on('click', '.btn-add-cash-advance-row', function () {
                cash_num += 1;
                let data = `
                    <div class="row" id="particular` + cash_num + `">
                        <div class="col-md-8" style="padding-bottom:2px;">
                            @php $particulars = \App\Models\FormParticular::oldest('name')->get() @endphp
                    <select type="text" name="particulars[]" class="form-control" style="padding: 2px 10px;height:auto">
                        <option>--</option>
@foreach($particulars as $particular)
                    <option>{{ $particular->name }}</option>
                                @endforeach
                    </select>
                </div>
                <div class="col-md-3" style="padding-bottom:2px;">
                    <input type="number" name="amount[]" id="authority-to-pay-amount" class="form-control" style="padding: 2px 10px;">
                </div>
                <div class="col-md-1 text-right" style="padding-bottom:2px;">
                    <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num-cash="` + cash_num + `" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                `;

                $('#new-cash-advance-particular').append(data);
                selectTwo('mySelect3');
                $('.btn-remove').click(function () {
                    $('#particular' + $(this).data('num-cash')).remove();
                    // alert($(this).data('num'))
                });
            });

            $('body').on('click', '.btn-add-row', function () {
                form_num += 1;
                let data = `
                    <div class="row" id="meal` + form_num + `">
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="date[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="breakfast[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="launch[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="dinner[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-1 text-right" style="padding-bottom:2px;">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num-meal="` + form_num + `" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $('#new-meal-allowance').append(data);
                selectTwo('mySelect3');
                $('.btn-remove').click(function () {
                    $('#meal' + $(this).data('num-meal')).remove();
                    // alert($(this).data('num'))
                });

            });

            $('body').on('click', '.add-attachment', function () {
                num += 1;
                let data = `
                <div class="row" id="item` + num + `">
                    <div class="col-md-6" style="padding-bottom:2px;">
                        <input type="text" name="attachment_name[]" class="form-control" placeholder="Attachment Name (if any)"
                        style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <input type="file" name="attachment[]" style="opacity: 100%;">
                    </div>
                    <div class="col-md-2 text-right" style="padding-bottom:2px;">
                        <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num="` + num + `" style="margin: 0 !important;">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                </div>
                `;
                $('#attachment').append(data);

                $('.btn-remove').click(function () {
                    $('#item' + $(this).data('num')).remove();
                    // alert($(this).data('num'))
                })
            });

            function selectTwo(param) {
                $('.' + param).select2({
                    minimumInputLength: 2,
                    ajax: {
                        type: 'GET',
                        dataType: 'json',
                        url: '{{ route('users.search.user','all') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public'
                            }
                            console.log(query)
                            return query;
                        },
                        processResults: function (data) {
                            console.log(data);
                            return {
                                results: data
                            }
                        }
                        , cache: true
                    }
                });
            }

            function selectTwoVehicle(param) {
                $('.' + param).select2({
                    minimumInputLength: 2,
                    ajax: {
                        type: 'GET',
                        dataType: 'json',
                        url: '{{ route('vehicles.select2.search') }}',
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

            $('.mySelect2').select2({
                minimumInputLength: 2,
                ajax: {
                    type: 'GET',
                    dataType: 'json',
                    url: '{{ route('users.search','all') }}',
                    data: function (params) {
                        console.log(params);
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        console.log(query);

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: data
                        }
                    }
                    , cache: true
                }
            });

            selectTwo('mySelect3');
        });
    </script>
@endpush
