@extends('layouts.app')

@section('content')
    @php
        $copy = explode(',',$memo->copy);
    @endphp
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{--{{ route('memos.print', $memo->id) }}--}}#" {{--target="_blank"--}} class="btn btn-default btn-sm btn-print">
                        <span class="fa fa-print"></span> Print
                    </a>
                </div>
                <div class="card-body" id="section-to-print">
                    <div class="text-center">
                        <img src="{{ asset('public/logo.jpg') }}" width="150" align="center" />
                    </div>
                    <h4 align="center"><strong style="font-weight: bolder">CAPITAL CITY UNIVERSITY, KANO</strong> <br>
                        <small>No. 20 Yusuf Maitama Sule Road, Nassarawa GRA, Kano - Nigeria</small>
                    </h4>
                    <h4 align="center"><span style="background: black; color:white;"> INTERNAL MEMO </span><h1/>
                        <table class="" width="100%">
                            <tr>
                                <td class="text-right" style="width: 100px;"><strong>From:</strong></td>
                                <td class="text-left">{{ $memo->raisedBy->fullName() }}</td>
                                <td class="text-right"><strong>Date:</strong></td>
                                <td class="text-left">{{ $memo->created_at }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>To:</strong></td>
                                <td class="text-left">{{ $memo->raisedFor->fullName() }}</td>
                                <td class="text-right"><strong>Cc:</strong></td>
                                <td class="text-left">
                                    @foreach($copy as $c)
                                        @php
                                            $user = App\Models\User::find($c);
                                        @endphp
                                        @if($user)
                                            {{ $user->fullName()  }}
                                            @if(!$loop->last) <br> @endif
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Memo No.:</strong></td>
                                <td class="text-left">{{ $memo->reference }}</td>
                                <td class="text-right"><strong>Attachments:</strong></td>
                                <td class="text-left">
                                    <ul style="list-style-type: none;margin-bottom: 0;">
                                        @if($memo->hasAttachment())
                                            @foreach($memo->attachments() as $attachment)
                                                <li>
                                                    {{ $loop->index+1 }}. <a target="_blank" href="{{asset('public/'.$attachment->name)}}" class="view-attachment-link1"
                                                                             index="{{$loop->index}}">{{ $attachment->usrName }}</a>
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
                        <h4 style="padding:0 16px;" align="center" class="card-title">{{--{{ strtoupper($memo->title) }}--}}</h4>
                        <div style="padding: 8px 16px 8px 24px;text-align: justify">
                            {!! $memo->body !!}
                        </div>

                        <div style="padding: 40px 16px 8px 24px;">
                            <div class="text-left">
                                @if(auth()->user()->signature())
                                    <img src="{{ asset('public/signatures/' . auth()->user()->signature()[0]->name) }}" width="100">
                                @else
                                    <span class="badge">No Signature</span>
                                @endif
                                <p class="text-left">
                                    <i>{{ $memo->raisedBy->fullName() }}</i><br>
                                    {{ strtoupper($memo->raisedBy->department()->name) }} Department<br>
                                    {{ strtoupper($memo->raisedBy->branch()->name) }} Branch<br>
                                    {{--                            <small><i>{{ $minute->created_at }}</i></small>--}}
                                </p>
                            </div>
                        </div>
                </div>
                <div class="card-footer ">
                    {{--@php $index = 1; @endphp
                    @foreach($memo->attachment() as $attachment)
                        <a href="{{ asset('attachments/'.$attachment->url) }}" target="_blank">Page {{$index}}</a>
                        @php $index++; @endphp
                    @endforeach--}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header ">
                    <h2 class="card-title">Minutes</h2>
                </div>
                <div class="card-body">
                    @if(($memo->lastMinuteTo() && $memo->lastMinuteTo()->id == Auth::id()) || (count($memo->minutes()) == 0 && $memo->raisedFor->id == Auth::id()))
                        <form action="{{ route('memos.minute.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="memo_id" value="{{ $memo->id }}">
                            <div class="form-group">
                                <label>To:</label>
                                <select class="form-control mySelect2" name="minuteto">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Minute:
                                    <a href="javascript:;" id="custom-messages" class="btn btn-outline-info btn-sm" style="padding:0 .5rem; font-size:10px">Custom Messages</a>
                                </label>
                                <textarea class="form-control" name="minute" id="minute"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Attachment</label>
                                <div id="attachment">
                                    <div class="row" id="item1">
                                        <div class="col-md-2" style="padding-bottom:2px;padding-right:0;padding-left:0;"></div>
                                        <div class="col-md-5" style="padding-bottom:2px;padding-right:0;padding-left:0;">
                                            <input type="text" name="attachment_name[]" class="form-control"
                                                   placeholder="Attachment Name (if any)"
                                                   style="padding: 2px 10px;">
                                        </div>
                                        <div class="col-md-5" style="padding-bottom:2px;padding-right:0;padding-left:0;">
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
                            <button type="submit" class="btn btn-success btn-sm">Send Minute</button>
                        </form>
                    @endif

                    <hr>

                    <div class="minutes-containe">
                        <table>
                            @php
                                $minutes = $memo->minutes();
                                $count = count($minutes);
                            @endphp
                            @foreach($minutes as $minute)
                                <tr>
                                    <th width="40" style="vertical-align: top;"><i
                                                class="badge badge-dark">{{ $count-$loop->index }}</i></th>
                                    <td width="90%" style="border:none !important;">
                                        <H5 class="ellipsis">{{ $minute->toUser->fullName() }}</H5>
                                        <p>
                                            @if($minute->confidentiality!="confidential")
                                                {{$minute->body}}
                                            @elseif($minute->to_user == Auth::id())
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
                                                    {{ $loop->index+1 }}. <a target="_blank" href="{{asset('public/'.$attachment->name)}}" class="view-attachment-link1"
                                                                             index="{{$loop->index}}">{{ $attachment->usrName }}</a>
                                                </li>
                                                {{--@if(!$loop->last) <br> @endif--}}
                                            @endforeach
                                        @endif
                                        {{--<a href="#" id="minute-attachment-link">Page 1</a>--}}
                                        <div class="text-right">
                                            @if(isset($minute->fromUser->signature()[0]))
                                                <img src="{{ asset('public/signatures/'.$minute->fromUser->signature()[0]->name) }}" width="70">
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
                        $messages = \App\Models\Message::where('user_id',auth()->id())->get();
                        /*$titles = DB::table('messages')->distinct()->get(['department_id']);*/
                        $titles = \App\Models\Message::where('user_id',auth()->id())->groupBy('department_id')->get();
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
                                <td style="vertical-align: top;text-align: left;padding:0 5px !important;font-size:14px !important;"><ul style="margin-bottom: 0;padding-left:25px;">
                                        @foreach($messages as $message)
                                            @if($titles[$i]->department_id == $message->department_id)
                                                <li> <a href="javascript:;" message="{{$message->message}}" class="add-custom-message">{{ $message->message }}</a></li>
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

@section('css')
    <style>
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

        /*@media print {
            body * {
                visibility: hidden;
            }

            #section-to-print, #section-to-print * {
                visibility: visible;
                width: 100vw;
                left:.01vw;
                !*page-break-after:always;*!
            }

            #section-to-print {
                position: absolute;
                left: 10px;
                top: 10px;
            }
        }*/

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
@push('js')
    <script>
        $(document).ready(function () {

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
            table tr td, table tr td + td, table tr th + th {
                font-size: 14px;
                text-align: left !important;
                padding: 2px !important;
                border: 1px solid #cccccc !important;
            }
            table tr td[rowspan], table tr td[colspan] {
                vertical-align: top;
            }</style>
            `;
            function PrintElem(elem, style="")
            {
                var mywindow = window.open('', 'PRINT', 'height=500,width=650');

                mywindow.document.write('<html><head><title>' + document.title  + '</title>');
                mywindow.document.write(style+'</head><body>');
                mywindow.document.write('<h1>' + document.title  + '</h1>');
                mywindow.document.write(document.getElementById(elem).innerHTML);
                mywindow.document.write('</body></html>');
                mywindow.print();
                // mywindow.close();

                // mywindow.document.close(); // necessary for IE >= 10
                // mywindow.focus(); // necessary for IE >= 10*/

                return true;
            }

            $('.btn-print').click(function(){
                PrintElem('section-to-print', style)
            })

            $('#custom-messages').on('click', function(){
                $('#custom-messages-modal').modal('toggle');
            });
            $('.add-custom-message').on('click', function(){
                $('#minute').html($(this).attr('message'));
                $('#custom-messages-modal').modal('toggle');
            });



            let num = 1;
            $('body').on('click', '.add-attachment', function () {
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
                $('#attachment').append(data);

                $('.btn-remove').click(function () {
                    $('#item' + $(this).data('num')).remove();
// alert($(this).data('num'))
                })
            });

            $("#minute-attachment-link").on("click", function (e) {
                $("#minute-attachment-modal").modal();
            });


            $(".view-attachment-link").on("click", function (e) {
                e.preventDefault();
                $(".box , .tt").hide();
                index = $(this).attr('index');
                $(".box[index='"+index+"'], #tt-"+index).show();
                $("#view-attachment-modal").modal();
            });

            $('.mySelect2').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'GET',
                    dataType: 'json',
                    url: '{{ route('users.search','staff') }}',
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
                        return {
                            results: data
                        }
                    }
                    , cache: true
                }
            });
        });
    </script>
@endpush
