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
                        <div class="col-md-6">
                            <h5 class="card-title">Memos</h5>
                            {{$status}}
                        </div>

                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="{{ route('memos.create') }}" class="btn btn-success btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                New Memo
                            </a>
                            <a href="{{ route('memos.create') }}" class="btn btn-primary btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="fa fa-plus"></i>
                              </span>
                                New Form
                            </a>
                            {{--<button class="btn btn-success btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="fa fa-cloud-upload"></i>
                              </span>
                                Upload Staff
                            </button>--}}
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
                        <table {{-- wire:poll.5000ms--}} id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Memo ID</th>
                                <th>Subject</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Active User</th>
                                <th class="text-right" width="200"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td> {{$loop->index+1 }} </td>
                                    <td> {{$record->reference}} </td>
                                    <td> <a href="{{route('memos.show',$record->id)}}">{{$record->title }} &nbsp;  </a></td>
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
                                    <td> {{$record->status }} <br> {!!  $record->readStatus() !!}  {!!  $record->hasAttachment() ? "<br> <i class='fa fa-file'></i>" : ""  !!}</td>
                                    <td>
                                        {!!  optional($record->lastMinuteTo())->fullname() ?? ($record->raisedFor->fullName() ?? null)  !!}<br>
                                        <i>{{ $record->lastMinute()->created_at ?? ($record->created_at ?? null) }}</i>
                                    </td>
                                    <td class="text-right" >

                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
