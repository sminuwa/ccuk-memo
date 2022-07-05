@extends('layouts.app')

@section('content')

    {{--<livewire:memo/>--}}

    <div>
        <div  class="row">
            <div class="col-md-12">


                {{-- Ring if new mail inserted--}}
                {{--@if($ringBool)
                    <audio autoplay>
                        <source src="{{ myAsset('public/ring.mp3') }}" type="audio/mpeg">
                    </audio>
                    @php $ringBool = false; @endphp
                @endif--}}

                <div class="card">
                    <div class="card-header">
                        {{--                    {{ \App\Models\User::find(auth()->id())->referenceCode() }}--}}
                        {{--                    {{ \App\Models\Memo::getLastMemo() }}--}}
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
                            <div class="col-md-12" >

                                <a href="{{ route('memos.filter.index') }}" class="btn btn-dark btn-sm btn-flat">
                                    <i class="fa fa-envelope-o"></i> New <span class="badge badge-danger">29</span>
                                </a>
                                <a href="{{ route('memos.archived') }}" class="btn btn-dark btn-sm btn-flat">
                                    <i class="fa fa-send-o"></i> Sent <span class="badge badge-danger">29</span>
                                </a>
                                <a href="{{ route('memos.archived') }}" class="btn btn-dark btn-sm btn-flat">
                                    <i class="fa fa-reply"></i> Received <span class="badge badge-danger">29</span>
                                </a>
                                <a href="{{ route('memos.archived') }}" class="btn btn-dark btn-sm btn-flat">
                                    <i class="fa fa-envelope-o"></i> All Memo <span class="badge badge-danger">0</span>
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
                        <div class="table-responsive">
                            <div class="text-right pt-2 pr-2">
                                <div class="" wire:loading wire:target="search, searchby">
                                    <img src="{{ myAsset('loader.gif') }}" width="35" alt="">
                                </div>
                                <select type="text" wire:model="perpage" name="perpage" class="form-control" style="width:10% !important;display:inline">
                                    <option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>200</option>
                                </select>
                                <select type="text" wire:model="searchby" name="searchby" class="form-control" style="width:20% !important;display:inline">
                                    <option value="">All</option>
                                    <option value="sent">Sent</option>
                                    <option value="received">Received</option>
                                    <option value="copied">Copied/Minuted</option>
                                    <option value="unseen">New</option>
                                    <option value="seen">Seen</option>
                                    <option value="read">Read</option>
                                </select>
                                <input type="text" wire:model="search" name="search" placeholder="Search" class="form-control inline" style="width:40% !important;display:inline">
                            </div>
                            <table  wire:poll.5000ms id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Memo ID</th>
                                    <th>Subject</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Date</th>
                                    <th width="200">Status/Type</th>
                                    <th>Active User</th>
                                    {{--<th class="text-right" width="200"></th>--}}
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
                                        {{--<td class="text-right" >--}}
                                        {{--<a class="btn btn-outline-secondary btn-sm" href="{{route('memos.show',$record->id)}}">
                                            View
                                        </a>--}}
                                        {{--@if($record->read_status == 'not seen')
                                            <a onclick="return confirm('Are you sure you want to recall this memo?')" class="btn btn-outline-secondary btn-sm" href="{{route('memos.show',$record->id)}}">
                                                Recall
                                            </a>
                                            <form onsubmit="return confirm('Are you sure you want to delete?')"
                                                  action="{{route('memos.destroy',$record->id)}}"
                                                  method="post"
                                                  style="display: inline">
                                                {{csrf_field()}}
                                                <button type="submit" class="btn btn-outline-danger btn-sm cursor-pointer">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif--}}

                                        {{--</td>--}}
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            {{--{{ $records->links() }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection


@push('js')

    <script>
        /*$(document).ready(function() {
            let audioElement = document.createElement('audio');
            audioElement.setAttribute('src', '{{ myAsset('ring.mp3') }}');

            audioElement.autoplay;

            audioElement.addEventListener('ended', function() {
                this.play();
            }, false);


            audioElement.addEventListener("canplay",function(){
                $("#length").text("Duration:" + audioElement.duration + " seconds");
                $("#source").text("Source:" + audioElement.src);
                $("#status").text("Status: Ready to play").css("color","green");
            });

            audioElement.addEventListener("timeupdate",function(){
                $("#currentTime").text("Current second:" + audioElement.currentTime);
            });

            $('#play').click(function() {
                audioElement.play();
                $("#status").text("Status: Playing");
            });

            $('#pause').click(function() {
                audioElement.pause();
                $("#status").text("Status: Paused");
            });

            $('#restart').click(function() {
                audioElement.currentTime = 0;
            });


            audioElement.addEventListener("canplaythrough", function() {
                /!* the audio is now playable; play it if permissions allow *!/

            });
            // audioElement.play();
            let last = 0;
            setInterval(function(){
                $.ajax({
                    url: "{{ route('memos.ringing') }}",
                    success: function(data){
                        if(last != data && last > 0){
                            audioElement.currentTime = 0;
                            audioElement.play();
                            // alert('Yes it worked')
                        }else{
                            audioElement.pause();
                        }
                        last = data
                    }
                })
            }, 10000);


        });*/
    </script>
@endpush
