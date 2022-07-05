@extends('layouts.app')

@section('content')

    {{--<livewire:memo/>--}}

    <div>
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
                                    <a href="javascript:history.back()" class="btn btn-warning btn-sm">
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

                                    <a href="{{ route('memos.new') }}" class="btn btn-dark btn-sm btn-flat">
                                        <i class="fa fa-envelope-o"></i> New <span class="badge badge-danger">{{ $newMemos }}</span>
                                    </a>
                                    <a href="{{ route('memos.sent') }}" class="btn btn-dark btn-sm btn-flat">
                                        <i class="fa fa-send-o"></i> Sent
                                    </a>
                                    <a href="{{ route('memos.received') }}" class="btn btn-dark btn-sm btn-flat">
                                        <i class="fa fa-reply"></i> Received <span class="badge badge-danger">{{ $newReceived }}</span>
                                    </a>
                                    <a href="{{ route('memos.index') }}" class="btn btn-dark btn-sm btn-flat">
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
                            {{--<div class="text-center m-3 loader">
                                <img src="{{ myAsset('loader.gif') }}" width="35" alt="">
                            </div>--}}
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
                                    <tbody>
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
                                                {{--@php print_r($record->formsTotalAmount()) @endphp--}}
                                                {{$record->type }} ({{ $record->status }})<br>
                                                {{--                                        {!! $record->acceptRetirement() ? $record->retirementStatus().'<br>' :'' !!}--}}
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
{{--                                {{ $records->links() }}--}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


@endsection


@section('js')

    <script>

        $('.loader').hide()

        /*$(document).ready(function(){
            setInterval(function(){
                // alert('Hello')
                $.ajax({
                    url:"{{ route('memos.received') }}",
                    type:'GET',
                    data: {
                        type: 'ajax'
                    },
                    beforeSend: function(){
                        // $('.loader').show()
                    },
                    success: function(data){
                        // $('.loader').hide()
                        $('.memos-section').html(data)
                        $('table.display').DataTable();
                    }
                })
            },10000)
        })*/
    </script>
@endsection
