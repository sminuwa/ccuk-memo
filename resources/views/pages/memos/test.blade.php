@extends('layouts.app')

@section('content')

    <livewire:memo :status="$status"/>

    {{--<div>
        <div  class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5 class="card-title">My Memos</h5>

                                </div>

                                <div class="col-md-9 text-right" >
                                    <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                        <span class="fa fa-close"></span>
                                    </a>
                                    <a href="{{ route('memos.filter.index') }}" class="btn btn-dark btn-sm btn-flat">
                                        <i class="nc-icon nc-paper"></i> Filter
                                    </a>
                                    @if(auth()->user()->canAccess('archived.close'))
                                        <a href="{{ route('memos.archived') }}" class="btn btn-dark btn-sm btn-flat">
                                            <i class="nc-icon nc-paper"></i> Archived
                                        </a>
                                    @endif
                                    <a href="{{ route('memos.create') }}" class="btn btn-success btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                        New Memo
                                    </a>
                                    <a href="{{ route('forms.create') }}" class="btn btn-primary btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="fa fa-plus"></i>
                              </span>
                                        New Form
                                    </a>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <a href="{{ route('memos.new') }}" class="btn btn-dark btn-sm btn-flat newMemo">
                                        <i class="fa fa-envelope-o"></i> New <span class="badge badge-danger">{{ $newMemos }}</span>
                                    </a>
                                    <a href="{{ route('memos.sent') }}" class="btn btn-dark btn-sm btn-flat sentMemo">
                                        <i class="fa fa-send-o"></i> Sent
                                    </a>
                                    <a href="{{ route('memos.received') }}" class="btn btn-dark btn-sm btn-flat receivedMemo">
                                        <i class="fa fa-reply"></i> Received <span class="badge badge-danger">{{ $newReceived }}</span>
                                    </a>
                                    <a href="{{ route('memos.index') }}" class="btn btn-dark btn-sm btn-flat allMemo">
                                        <i class="fa fa-envelope-o"></i> All Memo <span class="badge badge-danger">{{ $allMemos }}</span>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            --}}{{--<div class="text-center m-3 loader">
                                <img src="{{ myAsset('loader.gif') }}" width="35" alt="">
                            </div>--}}{{--
                            <div class="table-responsive memos-section">

                                <table class="table display table-bordered" style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Memo ID</th>
                                        <th>Subject</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Date</th>
                                        <th>Status/Type</th>
                                        <th>Active User</th>
                                    </tr>
                                    </thead>
                                    <tbody class="test-memo-section">
                                    @foreach($records as $record)
                                        <tr style="@if($record->isForm()) background:#f1f1e3 @endif">
                                            <td> {{$loop->index+1 }} </td>
                                            <td> {{$record->reference}} </td>
                                            <td> <a href="{{route('memos.show',$record->id)}}">{{$record->title }}</a></td>
                                            <td>
                                                @if($record->raisedBy->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$record->id)}}">
                                                        {{ $record->raisedBy->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($record->raisedFor->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$record->id)}}">
                                                        {{ $record->raisedFor->fullName() }}
                                                    </a>
                                                @endif

                                            </td>
                                            <td> {{ date('M jS, Y', strtotime($record->date_raised)) }} </td>
                                            <td>
                                                --}}{{--@php print_r($record->formsTotalAmount()) @endphp--}}{{--
                                                {{$record->type }} ({{ $record->status }})<br>
                                                --}}{{--                                        {!! $record->acceptRetirement() ? $record->retirementStatus().'<br>' :'' !!}--}}{{--
                                                {!! $record->readStatus() !!}
                                                {!! $record->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                            </td>
                                            <td>
                                                {!!  optional($record->lastMinuteTo())->fullname() ?? ($record->raisedFor->fullName() ?? null)  !!}<br>
                                                <i>{{ $record->lastMinute()->created_at ?? ($record->created_at ?? null) }}</i>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>

                                --}}{{--{{ $records->links() }}--}}{{--
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>--}}


@endsection

@section('css')
    <style>
        :root {
            --white: #ffffff;
            --light: #f0eff3;
            --black: #000000;
            --dark-blue: #1f2029;
            --dark-light: #353746;
            --red: #da2c4d;
            --yellow: #f8ab37;
            --grey: #ecedf3;
        }
        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;
            left: -9999px;
            width: 0;
            height: 0;
            visibility: hidden;
        }
        .checkbox:checked + label,
        .checkbox:not(:checked) + label {
            position: relative;
            display: inline-block;
            padding: 0;
            text-align: center;
            margin-top: 100px;
            height: 6px;
            border-radius: 4px;
            background-image: linear-gradient(298deg, var(--red), var(--yellow));
            z-index: 100 !important;
        }
        .checkbox-tools:checked + label,
        .checkbox-tools:not(:checked) + label {
            position: relative;
            display: inline-block;
            padding:  15px;
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 1px;
            margin-left: 5px;
            text-align: center;
            /*border-radius: 4px;*/
            overflow: hidden;
            cursor: pointer;
            text-transform: uppercase;
            color: var(--white);
        }
        .checkbox-tools:not(:checked) + label {
            /*background-color: var(--dark-light);*/
            background-image: linear-gradient(138deg, var(--red), var(--yellow));
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }
        .checkbox-tools:checked + label {
            color: var(--black);

            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            /*color: var(--black);*/
        }
        .checkbox-tools:not(:checked) + label:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            background-image: linear-gradient(138deg, var(--red), var(--yellow));
        }


    </style>
@endsection

@section('js')

    {{--<script>

        $('.loader').hide()

        $(document).ready(function(){
            let status = 'received'
            let perPage = 10;
            setInterval(function(){
                // alert('Hello')
                $.ajax({
                    url:"{{ route('memos.test') }}",
                    type:'GET',
                    data: {
                        type: 'ajax',
                        status: status,
                        perPage: perPage,
                    },
                    beforeSend: function(){
                        // $('.loader').show()
                    },
                    success: function(data){
                        // $('.loader').hide()
                        $('.test-memos-section').html(data)
                        $('table.display').DataTable();
                    }
                })
            },3000)
        })
    </script>--}}
@endsection
