@extends('layouts.app')

@section('content')
    @php
        $copy = explode(',',$memo->copy);
    @endphp
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-right">
                    <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                        <span class="fa fa-close"></span> Close
                    </a>
                    <a href="javascript:print();" class="btn btn-default btn-sm">
                        <span class="fa fa-print"></span> Print
                    </a>
                </div>
                <div class="card-body" id="section-to-print">
                    <table class="">
                        <tr>
                            <td class="text-right" style="width: 100px;"><strong>From:</strong></td>
                            <td class="text-left">{{ $memo->raisedBy->fullName() }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>To:</strong></td>
                            <td class="text-left">{{ $memo->raisedFor->fullName() }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Reference:</strong></td>
                            <td class="text-left">{{ $memo->reference }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Date:</strong></td>
                            <td class="text-left">{{ $memo->created_at }}</td>
                        </tr>
                        @if(count(array_filter($copy)) > 0)
                            <tr>
                                <td class="text-right" rowspan="{{ count($copy)+1 }}"><strong>Cc:</strong></td>
                            </tr>
                            @foreach($copy as $c)
                                @php
                                    $user = App\Models\User::find($c);
                                @endphp
                                @if($user)
                                    <tr>
                                        <td>{{ $user->fullName()  }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                    <hr style="background-color: #dfdfdf;margin-bottom: 30px;">
                    <h4 style="padding:0 16px;" align="center" class="card-title">{{ strtoupper($memo->title) }}</h4>
                    <div style="padding: 8px 16px 8px 24px;text-align: justify">
                        {!! $memo->body !!}
                    </div>

                    <div style="padding: 40px 16px 8px 24px;">
                        @if($memo->attachments())
                            <div class="text-right">
                                <p style="padding:0;margin:0;color:#afafaf;">Attachment(s):</p>
                                <ul style="list-style-type: none;">
                                    @foreach($memo->attachments() as $attachment)
                                        <li>
                                            <a href="#" class="view-attachment-link"
                                               index="{{$loop->index}}">{{ $attachment->usrName }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-left">
                            <img src="{{ asset('signatures/'.auth()->user()->signature()[0]->name) }}" width="100">
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
                                <label>Minute:</label>
                                <textarea class="form-control" name="minute"></textarea>
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
                                            <label for="upload">Choose file</label>
                                            <input type="file" hidden id="upload" name="attachment[]"
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
                                    <td width="90%">
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
                                        @foreach($minute->attachment() as $attachment)
                                            <a href="{{ asset('attachments/minutes/'.$attachment->url) }}"
                                               target="_blank">Page {{$index}}</a>
                                            @php $index++; @endphp
                                        @endforeach
                                        {{--<a href="#" id="minute-attachment-link">Page 1</a>--}}
                                        <div class="text-right">
                                            <img src="{{ asset('signatures/'.$minute->fromUser->signature()[0]->name) }}" width="70">
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


    <div class="modal fade" id="minute-attachment-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Attachment</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="view-attachment-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Attachments</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div style="width: 640px;border: 1px #333 solid;min-height:480px;overflow: auto;">
                                @foreach($memo->attachments() as $attachment)
                                    {{--                                    <a href="#" class="view-attachment-link">{{ $attachment->usrName }}</a>--}}
                                    <div class="box" style="width: 640px;overflow: auto;display:none;"
                                         index="{{$loop->index}}">
                                        <img src="{{ asset($attachment->name) }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <center>
                                <div id="attachname">
                                    <ul style="list-style-type: none;">
                                        @foreach($memo->attachments() as $attachment)
                                            <li style="display: none;" class="tt"
                                                id="tt-{{$loop->index}}">{{ $attachment->usrName }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </center>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
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
        table tr td, table tr td + td {
            font-size: 14px;
            text-align: left !important;
            padding: 2px !important;
            border: none !important;
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

        #upload-label {
            display: inline-block;
            background-color: indigo;
            color: white;
            padding: 0.5rem;
            font-family: sans-serif;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
        }
    </style>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            let num = 1;
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
                    url: '{{ route('users.search') }}',
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
