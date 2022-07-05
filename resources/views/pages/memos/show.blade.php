@extends("layouts.app")

@section("content")
    {{--@php $u = Auth::user(); @endphp--}}
    @php $user = Auth::user(); $r = request(); @endphp
    @php
        $copy = explode(",",$memo->copy);
    @endphp
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-right">
                    <a href="javascript:history.back()" class="btn btn-warning btn-sm">
                        <span class="fa fa-close"></span> Close
                    </a>
                    <a href="{{ route('memos.kiv', $memo->id) }}" class="btn btn-success btn-sm">
                        {!! $memo->kiv() ? '<span class="fa fa-star"></span>' : '<span class="fa fa-star-o"></span>' !!} KIV
                    </a>
                    @if($memo->status == "open")
                        @if($user->canAccess("archived.close"))
                            <a href="{{ route("memos.archive", $memo->id) }}" class="btn btn-success btn-sm">
                                <span class="fa fa-archive"></span> Archive
                            </a>
                        @endif
                    @endif
                    @if($memo->status != "open")
                        @if($user->canAccess("archived.reopen"))
                            <a href="{{ route("memos.archive", $memo->id) }}" class="btn btn-success btn-sm">
                                <span class="fa fa-archive"></span> Re-Open
                            </a>
                        @endif
                    @endif

                    {{--<a href="{{ route("memos.print", $memo->id) }}" target="_blank" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> Print
                    </a>--}}
                    <a href="javascript:;" class="btn btn-default btn-sm btn-print">
                        <span class="fa fa-print"></span> Print Memo
                    </a>
                </div>
                <div class="card-body" id="printable-memo">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="text-center">
                        <img src="{{ myAsset("logo.jpg") }}" width="100"/>
                    </div>
                    <h4 align="center"><strong style="font-weight: bolder">CAPITAL CITY UNIVERSITY, KANO</strong>
                        <br>
                        <small>No. 20 Yusuf Maitama Sule Road, Nassarawa GRA, Kano - Nigeria</small>
                    </h4>
                    @if($memo->type == \App\Models\Memo::TYPE_VEHICLE)
                        {!! VehicleForm($memo) !!}
                    @else
                        <h4 class="text-center"><span style="background: black; color:white;">&nbsp; INTERNAL MEMO &nbsp;</span></h4>
                        <table style="width:100%">
                            <tr>
                                <td class="text-right" style="width: 100px;"><strong>From:</strong></td>
                                <td class="text-left">{{ $memo->raisedBy->fullName() }}</td>
                                <td class="text-right"><strong>Date:</strong></td>
                                <td class="text-left">{{ $memo->date_raised }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>To:</strong></td>
                                <td class="text-left">{{ $memo->raisedFor->fullName() }}</td>
                                <td class="text-right"><strong>Cc:</strong></td>
                                <td class="text-left">
                                    @if($memo->type == \App\Models\Memo::TYPE_MEMO)
                                        @foreach($copy as $c)
                                            @php
                                                $user = App\Models\User::find($c);
                                            @endphp
                                            @if($user)
                                                {{ $user->fullName()  }}
                                                @if(!$loop->last) <br> @endif
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($memo->type == \App\Models\Memo::TYPE_FORM)
                                        All {{ $memo->title }} Form Beneficiaries
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Memo No.:</strong></td>
                                <td class="text-left">{{ $memo->reference }}</td>
                                <td class="text-right"><strong>Attachments:</strong></td>
                                <td class="text-left">
                                    <ul style="list-style-type: none;margin-bottom: 0;padding-left: 5px;">
                                        @if($memo->hasAttachment())
                                            @foreach($memo->attachments() as $attachment)
                                                <li>
                                                    {{ $loop->index+1 }}. <a target="_blank"
                                                                             href="{{myAsset($attachment->name)}}"
                                                                             class="view-attachment-link1"
                                                                             index="{{$loop->index}}">{{ $attachment->usrName ?? $attachment->name }}</a>
                                                </li>
                                                {{--@if(!$loop->last) <br> @endif--}}
                                            @endforeach
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Subject:</strong></td>
                                <td class="text-left" colspan="3">{{ strtoupper($memo->title) }}</td>
                            </tr>
                        </table>
                        <div class="mt-3" style="padding: 8px 16px 8px 16px;text-align: justify">
                            {!! $memo->body !!}

                            @if($memo->acceptRetirement())
                                @if($memo->hasRetired())
                                <p class="mt-lg-3"><strong>Summary</strong></p>
                                <table class="table table-bordered table-striped" width="100%">
                                    <tr>
                                        <th>#</th>
                                        <th>Summary</th>
                                        <th>Amount</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Amount Received</td>
                                        <td>{{ number_format($memo->formsTotalAmount()) }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Total Amount Expended</td>
                                        <td>{{ number_format($memo->retirementTotalAmount()) }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Excess</td>
                                        <td>@if($memo->formsTotalAmount() > $memo->retirementTotalAmount()) {{ number_format($memo->formsTotalAmount() - $memo->retirementTotalAmount()) }} @else
                                                - @endif</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Shortage</td>
                                        <td>@if($memo->formsTotalAmount() < $memo->retirementTotalAmount()) {{ number_format($memo->retirementTotalAmount() - $memo->formsTotalAmount() ) }} @else
                                                - @endif</td>
                                    </tr>
                                </table>
                                @endif
                                <div class="text-right">
                                    <button class="btn btn-primary btn-sm retirement-form-btn">Retirement Form</button>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div style="padding: 40px 16px 8px 16px;">
                        <div class="text-left">
                            @if($memo->raisedBy->signature())
                                <img src="{{ myAsset("signatures/" . $memo->raisedBy->signature()[0]->name) }}"
                                     width="100">
                            @else
                                <span class="badge">No Signature</span>
                            @endif
                            <p class="text-left">
                                <i>{{ $memo->raisedBy->fullName() }}</i><br>
                                {{ strtoupper(optional($memo->raisedBy->department())->name) }} Department<br>
                                {{ strtoupper(optional($memo->raisedBy->branch())->name) }} Branch<br>
                                {{--                            <small><i>{{ $minute->created_at }}</i></small>--}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
            @if(auth()->user()->canAccess("memos.payment_auditor"))
                @include('pages.includes.payment-process')
            @endif

        </div>
        <!--Minute-->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title">Minutes</h3>
                </div>
                <div class="card-body">
                    @if($memo->status == "open")
                        @if(($memo->lastMinuteTo() && $memo->lastMinuteTo()->id == auth()->id()) || (count($memo->minutes()) == 0 && $memo->raisedFor->id == auth()->id()))
                            <form id="minute-form" action="{{ route("memos.minute.store") }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="memo_id" value="{{ $memo->id }}">
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>To:</label>
                                            <select class="form-control mySelect3" name="minuteto" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <small>Back to sender</small>
                                            </label>
                                            <input type="checkbox" id="back-to-sender">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mt-2">
                                        <span class="dot red" title="GM Finance"></span>
                                        <span class="dot green" title="GM Transport"></span>
                                        <span class="dot blue" title="GM HR"></span>
                                        <span class="dot pink" title="GM Control"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Minute:
                                        <a href="javascript:;" id="custom-messages" class="btn btn-outline-info btn-sm"
                                           style="padding:0 .5rem; font-size:10px">Custom Messages</a>
                                    </label>
                                    <textarea class="form-control" name="minute" id="minute" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Attachment</label>
                                    <div id="attachment">
                                        <div class="row" id="item1">
                                            <div class="col-md-2"
                                                 style="padding-bottom:2px;padding-right:0;padding-left:0;"></div>
                                            <div class="col-md-5"
                                                 style="padding-bottom:2px;padding-right:0;padding-left:0;">
                                                <input type="text" name="attachment_name[]" class="form-control"
                                                       placeholder="Attachment Name (if any)"
                                                       style="padding: 2px 10px;">
                                            </div>
                                            <div class="col-md-5"
                                                 style="padding-bottom:2px;padding-right:0;padding-left:0;">
                                                <label id="upload_label">Browse..</label>
                                                <input type="file" name="attachment[]"
                                                       style="opacity: 100%;">
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
                                <label><input type="checkbox" name="Confidentiality"> Confidential </label><br>
                                <button type="submit" id="send-minute-btn" class="btn btn-success btn-sm">Send Minute</button>
                                <div>
                                @if($memo->hasPaymentApproval())
                                    @if(auth()->user()->canAccess("memos.payment_process"))
                                        <a href="javascript:;" id="payment-btn" class="btn btn-dark btn-sm">Payment</a>
                                    @endif
                                @else
                                    @if(auth()->user()->canAccess("memos.approve_payment"))
                                        <a href="{{ route('memos.approve-status', ['memo_id'=>$memo->id]) }}" class="btn btn-warning btn-sm">Payment Approval</a>
                                    @endif
                                @endif
                                </div>
                            </form>
                        @endif
                    @else
                        <img src="{{ myAsset("archived.jpg") }}" width="100%"/>
                    @endif

                    <hr>
                    @if(auth()->user()->canAccess('memos.payment_process.print'))
                        @if($memo->paymentProcess()->count() > 0)
                            <div id="" style="">
                                <h4 align="center"><span style="background: black; color:white;font-size: 18px">&nbsp; Payment Process &nbsp;</span>
                                </h4>
                                @include('pages.includes.payment-process')
                            </div>
                            @if(auth()->user()->canAccess('print-payment-process'))
                            <a href="javascript:;" class="btn btn-dark btn-sm btn-print-payment">
                                <span class="fa fa-print"></span> Print Payment
                            </a>
                            @endif
                            @if(auth()->user()->canAccess('cancel-payment-process'))
                            <a onclick="return confirm('Are you sure you want to cancel this payment?')" href="{{ route('memos.cancel_payment_process', $memo->id) }}" class="btn btn-danger btn-sm btn-cancel-payment">
                                <span class="fa fa-times"></span> Cancel
                            </a>
                            @endif
                        @endif
                    @endif
                    <div>
                        <table>
                            @php
                                $minutes = $memo->minutes();
                                $count = count($minutes);
                            @endphp
                            @foreach($minutes as $minute)
                                <tr>
                                    <th width="40" style="vertical-align: top;">
                                        <i class="badge badge-dark">{{ $count-$loop->index }}</i>
                                    </th>
                                    <td width="90%" style="border:none !important;">
                                        @if($loop->first)
                                            @if($minute->status == 'not seen' && $minute->from_user == auth()->id())
                                                <div style="float:right">
                                                    <a href="{{ route('memos.minute.cancel',$minute->id) }}" class="text-danger"><span class="fa fa-times"></span></a><br>
                                                </div>
                                            @endif
                                        @endif
                                        <H5 class="ellipsis">{{ $minute->toUser->fullName() }}</H5>
                                        <p>
                                            @if($minute->confidentiality!="confidential")
                                                {{$minute->body}}
                                            @elseif($minute->to_user == auth()->id())
                                                {{$minute->body}}
                                            @else
                                                @php $body = $minute->body; $str="";@endphp
                                                @for($i=0;$i<strlen($body);$i++)
                                                    @php $str.= $body[$i]==" "?" ":"x"; @endphp
                                                @endfor
                                                {{ $str }}
                                            @endif
                                        </p>
                                        @php $index = 1; @endphp
                                        @if($minute->hasAttachment() && $minute->attachments())
                                            @foreach($minute->attachments() as $attachment)
                                                <li>
                                                    {{ $loop->index+1 }}. <a target="_blank"
                                                                             href="{{myAsset($attachment->name)}}"
                                                                             class="view-attachment-link1"
                                                                             index="{{$loop->index}}">{{ $attachment->usrName ?? $attachment->name}}</a>
                                                </li>
                                                {{--@if(!$loop->last) <br> @endif--}}
                                            @endforeach
                                        @endif
                                        {{--<a href="#" id="minute-attachment-link">Page 1</a>--}}
                                        <div class="text-right">
                                            @if(isset($minute->fromUser->signature()[0]))
                                                <img src="{{ myAsset("signatures/" . $minute->fromUser->signature()[0]->name) }}"
                                                     width="70">
                                            @else
                                                No Signature
                                            @endif
                                        </div>
                                        <p class="text-right">
                                            <i>{{ $minute->fromUser->fullName() }}</i><br>
                                            <small><i>{{ $minute->created_at }}</i></small>
                                        </p>
                                        <hr>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="printable-minutes" style="display: none;">
        <table>
            @php
                $minutes = $memo->minutes();
                $count = count($minutes);
            @endphp
            <tr>
                <th>#</th>
                <th>From</th>
                <th>To</th>
                <th>Minute</th>
                <th>Attachment</th>
                <th>Date</th>
                <th>Sign</th>
            </tr>
            @foreach($minutes as $minute)
                <tr>
                    <td width="40" style="vertical-align: top;"><i
                                class="badge badge-dark">{{ $count-$loop->index }}</i></td>
                    <td>{{ $minute->fromUser->fullName() }}</td>
                    <td>{{ $minute->toUser->fullName() }}</td>
                    <td>
                        @if($minute->confidentiality!="confidential")
                            {{$minute->body}}
                        @elseif($minute->to_user == auth()->id())
                            {{$minute->body}}
                        @else
                            @php $body = $minute->body; $str="";@endphp
                            @for($i=0;$i<strlen($body);$i++)
                                @php $str.= $body[$i]==" "?" ":"x"; @endphp
                            @endfor
                            {{ $str }}
                        @endif
                    </td>
                    <td>
                        @if($minute->hasAttachment() && $minute->attachments()) Yes @else No @endif
                    </td>
                    <td>
                        {{ $minute->created_at }}
                    </td>
                    <td>
                        @if(isset($minute->fromUser->signature()[0]))
                            <img src="{{ myAsset("signatures/" . $minute->fromUser->signature()[0]->name) }}"
                                 width="70">
                        @else
                            No Signature
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @php $paymentProcess = $memo->paymentProcess()->first(); @endphp
    <div id="printable-payment" style="display: none;">
        <div class="text-center">
            <img src="{{ myAsset("logo.jpg") }}" width="150"/>
        </div>
        <h4 align="center"><strong style="font-weight: bolder">CAPITAL CITY UNIVERSITY, KANO</strong> <br>
            <small>No. 20 Yusuf Maitama Sule Road, Nassarawa GRA, Kano - Nigeria</small>
        </h4>
        <h4 align="center"><span style="background: black; color:white;"> Payment Process (Memo ID: {{ $memo->reference }}) </span>
        </h4>
        @include('pages.includes.payment-process')
        {{--<table class="" width="100%">
            <tr>
                <td class="text-right" style="text-align: right;width: 200px;"><strong>Memo ID:</strong></td>
                <td class="text-left">{{ $memo->reference }}</td>
            </tr>
            <tr>
                <td class="text-right" style="text-align: right;"><strong>Account Debited:</strong></td>
                <td class="text-left">{{ optional($paymentProcess)->account_debited }}</td>
            </tr>
            <tr>
                <td class="text-right" style="text-align: right;"><strong>Account Credited:</strong></td>
                <td class="text-left">{{ optional($paymentProcess)->account_credited }}</td>
            </tr>
            <tr>
                <td class="text-right" style="text-align: right;"><strong>Amount:</strong></td>
                <td class="text-left">{{ optional($paymentProcess)->amount }}</td>
            </tr>
            {!! optional($paymentProcess)->beneficiary !!}
            <tr>
                <td class="text-right" style="text-align: right;"><strong>Narration:</strong></td>
                <td class="text-left">{{ optional($paymentProcess)->narration }}</td>
            </tr>
            <tr>
                <td class="text-right" style="text-align: right;"><strong>Date:</strong></td>
                <td class="text-left">{{ optional($paymentProcess)->created_at }}</td>
            </tr>
        </table>--}}
    </div>

    @if($memo->acceptRetirement())
    <div class="modal fade" id="retirement-form-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ADVANCE RETIREMENT FORM</h4>
                </div>
                <div class="modal-body">
                    <form class="retirement-form" action="{{ route('forms.store_retirements') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="memo_id" value="{{$memo->id}}">
                        <h4>Particulars</h4>
                        @for($i = 0; $i < count($memo->formData()->particulars); $i++)
                            <div class="row">
                                <div class="col-md-8" style="padding-bottom:2px;">
                                    <select type="text" class="form-control" style="padding: 2px 10px;height:auto">
                                        <option>{{ $memo->formData()->particulars[$i] }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4" style="padding-bottom:2px;">
                                    <input type="number" name="amount[]"
                                           value="@if($memo->hasRetired()) {{ $memo->formData()->retirements[$i] }} @endif" placeholder="Amount"
                                           class="form-control" style="padding: 2px 10px;">
                                </div>
                            </div>
                        @endfor
                        <hr>
                        <p class="text-danger">Please attach all the neccessary receipts for this retirement</p>
                        <div class="form-group">
                            <label>Attachment Name</label>
                            <div id="attachment">
                                <div class="row" id="retirement1">
                                    <div class="col-md-5" style="padding-bottom:2px;">
                                        <input type="text" name="attachment_name[]" class="form-control"
                                               placeholder="Attachment Name"
                                               style="padding: 2px 10px;">
                                    </div>
                                    <div class="col-md-7" style="padding-bottom:2px;">
                                        <input type="file" name="attachment[]" style="opacity: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="javascript:;" class="btn btn-success btn-sm add-retirement-attachment">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close
                        <button type="button" class="btn btn-success btn-sm waves-effect retirement-form-submit">Save
                            retirement
                        </button>
                </div>
            </div>

        </div>
    </div>
    @endif
    <div class="modal fade" id="payment-modal" role="dialog">
        <div class="modal-dialog" style="padding-top:0;margin-top:0">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-left">Payment Process</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal payment-form" action="{{ route('memos.payment_process') }}"
                          method="post">
                        @csrf
                        <input type="hidden" name="memo_id" class="form-control" value="{{ $memo->id }}">
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Reference:</label>
                            <div class="col-md-8">
                                <input type="text" disabled class="form-control" value="{{ $memo->reference }}">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Account Debited:</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <select name="account_debited[]" multiple="multiple" class="form-control expenditure-code-select2">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Account Credited:</label>
                            <div class="col-md-8">
                                <select name="account_credited[]" multiple="multiple" class="form-control expenditure-code-select2">
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Approved Amount:</label>
                            <div class="col-md-8">
                                <input type="number" name="amount" class="form-control">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Beneficiary Type:</label>
                            <div class="col-md-8">
                                <select type="text" name="beneficiary_type" id="beneficiary_type" class="form-control">
                                    <option></option>
                                    <option>Transfer</option>
                                    <option>Cheque</option>
                                    <option>Cash</option>
                                </select>
                            </div>
                        </div>
                        <div id="beneficiary">

                        </div>
                        <div class="row" style="margin-bottom:5px;">
                            <label class="col-md-4 text-right">Narration:</label>
                            <div class="col-md-8">
                                <textarea type="text" name="narration" class="form-control pr-3 pl-3"></textarea>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close
                    </button>
                    <a href="javascript:;" class="btn btn-success btn-sm waves-effect btn-payment-submit">Submit</a>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="custom-messages-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Custom Messages</h4>
                </div>
                <div class="modal-body">
                    @php
                        $messages = \App\Models\Message::where("user_id",auth()->id())->get();
                        $titles = \App\Models\Message::where("user_id",auth()->id())->distinct()->get(["department_id"]);
                        $total_titles = $titles->count();
                    @endphp
                    <table width="100%">
                        <tr>
                            @for($i = 0; $i < $total_titles; $i++)
                                <th style="border:1px solid #aaa;padding:0 10px !important;font-size:14px !important;">{{ $titles[$i]->department->name ?? "General" }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for($i = 0; $i < $total_titles; $i++)
                                <td style="vertical-align: top;text-align: left;padding:0 5px !important;font-size:14px !important;">
                                    <ul style="margin-bottom: 0;padding-left:25px;">
                                        @foreach($messages as $message)
                                            @if($titles[$i]->department_id == $message->department_id)
                                                <li><a href="javascript:;" message="{{$message->message}}"
                                                       class="add-custom-message">{{ $message->message }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                            @endfor
                        </tr>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close
                    </button>
                </div>
            </div>

        </div>
    </div>

@endsection

@section("css")
    <style>
        .dot {
            height: 25px;
            width: 25px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
        }
        .red{
            background-color: red;
        }
        .green{
            background-color:green;
        }
        .blue{
            background-color:blue;
        }
        .pink{
            background-color:pink;
        }
        .select2 {
            width: 100% !important;
        }
        table tr td, table tr td + td, table tr th + th {
            font-size: 14px;
            text-align: left !important;
            padding: 2px !important;
            border: 1px solid #cccccc !important;
        }

        table tr td[rowspan], table tr td[colspan] {
            vertical-align: top;
        }

        .ellipsis {
            white-space: nowrap;
            width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .minutes-container {
            height: 250px;
            overflow-y: scroll;
        }

        .inputfile:focus + label,
        .inputfile + label:hover {
            /*background-color: red;*/
        }

        .inputfile + label {
            cursor: pointer; /* "hand" cursor */
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print, #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 10px;
                top: 10px;
            }
        }

        /*#upload-label {
            display: inline-block;
            background-color: indigo;
            color: white;
            padding: 0.5rem;
            font-family: sans-serif;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
        }*/
    </style>
@endsection

@section("js")
    <script>
        $(document).ready(function () {
            selectTwo('mySelect3')

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

            $('.retirement-form-btn').click(function () {
                $('#retirement-form-modal').modal();
            })

            $('#beneficiary_type').change(function () {
                if ($(this).val() == "Cheque") {
                    $('#beneficiary').html(`
                    <div class="row" style="margin-bottom:5px;">
                        <label class="col-md-4 text-right">Beneficiary Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="beneficiary_name" class="form-control">
                        </div>
                    </div>`);
                } else if ($(this).val() == "Transfer") {
                    $('#beneficiary').html(`
                    <div class="row" style="margin-bottom:5px;">
                        <label class="col-md-4 text-right">Beneficiary Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="beneficiary_name" class="form-control">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:5px;">
                        <label class="col-md-4 text-right" style="font-size:14px">Beneficiary Account:</label>
                        <div class="col-md-8">
                            <input type="text" name="beneficiary_account" class="form-control">
                        </div>
                    </div>
                      <div class="row" style="margin-bottom:5px;">
                        <label class="col-md-4 text-right">Beneficiary Bank:</label>
                        <div class="col-md-8">
                            <input type="text" name="beneficiary_bank" class="form-control">
                        </div>
                    </div>`);
                } else if ($(this).val() == "Cash") {
                    $('#beneficiary').html(`
                    <div class="row" style="margin-bottom:5px;">
                        <label class="col-md-4 text-right">Beneficiary Name:</label>
                        <div class="col-md-8">
                            <input type="text" name="beneficiary_name" class="form-control">
                        </div>
                    </div>`);
                } else {
                    $('#beneficiary').html(``);
                }
            });

            $('#back-to-sender').change(function () {
                if ($(this).is(':checked')) {
                    let data = {
                        id: '{{ optional($memo->lastMinuteFrom())->id }}',
                        text: '{{ optional($memo->lastMinuteFrom())->fullName() }}'
                    };
                    let newOption = new Option(data.text, data.id, false, false);
                    $('.mySelect3').append(newOption).trigger('change');
                } else {
                    let newOption = new Option(null, null, false, false);
                    $('.mySelect3').append(newOption).trigger('change');
                }
            });

            $('.red').click(function () {
                $('.mySelect3').val('').trigger('change');
                $('.mySelect3').select2({
                    placeholder: "Testing placeholder",
                    data: {
                      id: 1,
                      text: 'DSample',
                    },
                    initSelection: function(element, callback) {
                    }
                });
                /*let dataa = {
                    id: '4',
                    text: 'GM Control'
                };
                let newOption = new Option(dataa.text, dataa.id, false, false);
                $('.mySelect3').append(newOption).trigger('change');*/
            });
            $('.green').click(function () {
                let dataa = {
                    id: '5',
                    text: 'GM Finance'
                };
                let newOption = new Option(dataa.text, dataa.id, false, false);
                $('.mySelect3').append(newOption).trigger('change');
            });


            let style = `
            <style>
            .text-center{ text-align:center; }
            body{
                font-family: "Roboto", sans-serif;
                margin: 0;
                font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
            }
            table tr td, table tr th, table tr td + td, table tr th + th {
                font-size: 14px;
                text-align: left;
                padding: 2px !important;
                border: 1px solid #cccccc !important;
            }
            table tr td[rowspan], table tr td[colspan] {
                vertical-align: top;
            }
            @media print {
              #printable-memo {page-break-after: always !important;}
              #printable-minutes {page-break-before: always !important;}
            }
            </style>
           `;
            

            $(".btn-print").click(function () {
                // alert('hello');
                PrintElem("printable-memo", "printable-minutes", style)
            });

            $(".btn-print-payment").click(function () {
                // alert('hello');
                PrintElem("printable-payment", "", style)
            });

            $("#custom-messages").on("click", function () {
                $("#custom-messages-modal").modal("toggle");
            });
            $(".add-custom-message").on("click", function () {
                $("#minute").html($(this).attr("message"));
                $("#custom-messages-modal").modal("toggle");
            });

            $("#minute-form").on("submit", function () {
                $("#send-minute-btn").prop("disabled", true)
            });

            $('.retirement-form-submit').click(function () {
                $('.retirement-form').submit()
            });

            let num = retirement_num = 1;
            $("body").on("click", ".add-retirement-attachment", function () {
                retirement_num += 1;
                let data = `
                    <div class="row" id="retirement` + retirement_num + `">
                        <div class="col-md-5">
                            <input type="text" name="attachment_name[]" class="form-control" placeholder="Attachment Name"
                            style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-5">
                            <input type="file" name="attachment[]" style="opacity: 100%;width:100px">
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-retirement="` + retirement_num + `" style="margin: 0 !important;">
                              <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $("#attachment").append(data);

                $(".btn-remove").click(function () {
                    $("#retirement" + $(this).data("retirement")).remove();
                });
            });
            $("body").on("click", ".add-attachment", function () {
                num += 1;
                let data = `
                    <div class="row" id="item` + num + `">
                    <div class="col-md-2 text-right" style="padding-bottom:2px;padding-right:0;padding-left:0;">
                    <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num="` + num + `" style="margin: 0 !important;">
                    <i class="fa fa-minus"></i>
                    </a>
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;padding-right:0;padding-left:0;">
                    <input type="text" name="attachment_name[]" class="form-control" placeholder="Attachment Name (if any)"
                    style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-5" style="padding-bottom:2px;padding-right:0;padding-left:0;">

                                <input type="file" name="attachment[]"
                                       style="opacity: 100%;width:100px">
                    </div>

                    </div>
                    `;
                $("#attachment").append(data);

                $(".btn-remove").click(function () {
                    $("#item" + $(this).data("num")).remove();
// alert($(this).data("num"))
                })
            });

            $("#minute-attachment-link").on("click", function (e) {
                $("#minute-attachment-modal").modal();
            });

            expenditure_code_select2('expenditure-code-select2');

            function expenditure_code_select2(className){
                $("."+className).select2({
                    minimumInputLength: 2,
                    theme: "classic",
                    placeholder: 'Select code',
                    tags: true,
                    tokenSeparators: [',', ' '],
                    ajax: {
                        type: "GET",
                        dataType: "json",
                        url: '{{ route('expenditure_codes.select2Ajax') }}',
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: 'public'
                            }

                            // console.log(query);
                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function (data) {
                            console.log(data);
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
            }

            $(".mySelect2").select2({
                minimumInputLength: 2,
                ajax: {
                    type: "GET",
                    dataType: "json",
                    url: '{{ route("users.search","staff") }}',
                    data: function (params) {
                        console.log(params);
                        var query = {
                            search: params.term,
                            type: "public"
                        }
                        console.log(query);

// Query parameters will be ?search=[term]&type=public
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

            $('#payment-btn').click(function () {
                $('#payment-modal').modal();
            });

            $('.btn-payment-submit').click(function () {
                $('.payment-form').submit();
            });
        });
    </script>
@endsection
