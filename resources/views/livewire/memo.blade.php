<div>
    <div class="row">
        <x-overlay-loader wire:loading wire:target="status, search, searchby, nextPage, previousPage, gotoPage" />
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <h5 class="card-title">My Memos</h5>
                        </div>

                        <div class="col-md-9 text-right">
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
                            <a href="{{ route('memos.create') }}" class="btn btn-success btn-sm btn-flat"
                               id="add-staff-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                New Memo
                            </a>
                            <a href="{{ route('forms.create') }}" class="btn btn-primary btn-sm btn-flat"
                               id="add-staff-btn">
                              <span class="btn-label">
                                <i class="fa fa-plus"></i>
                              </span>
                                New Form
                            </a>

                        </div>
                    </div>

                    <div class="row justify-content-center ">
                        <div class="col-12">
                            <input class="checkbox-tools" type="radio" wire:model="status" value="all" name="status" id="tool-1" checked>
                            <label class="for-checkbox-tools" for="tool-1">
                                <i class='fa fa-envelope-o'></i>
                                All <span class="badge badge-dark mb-0">{{ $allMemos }}</span>
                            </label>
						    <input class="checkbox-tools" type="radio" wire:model="status" value="new" name="status" id="tool-2">
                            <label class="for-checkbox-tools" for="tool-2">
                                <i class='fa fa-envelope-o'></i>
                                New <span class="badge badge-dark mb-0">{{ $newMemos }}</span>
                            </label>
						    <input class="checkbox-tools" type="radio" wire:model="status" value="received" name="status" id="tool-3">
                            <label class="for-checkbox-tools" for="tool-3">
                                <i class='fa fa-reply-all'></i>
                                Received <span class="badge badge-dark mb-0">{{ $newReceived }}</span>
                            </label>
						    <input class="checkbox-tools" type="radio" wire:model="status" value="sent" name="status" id="tool-4">
                            <label class="for-checkbox-tools" for="tool-4">
                                <i class='fa fa-send-o'></i>
                                Sent
                            </label>
                            <input class="checkbox-tools" type="radio" wire:model="status" value="copied" name="status" id="tool-5">
                            <label class="for-checkbox-tools" for="tool-5">
                                <i class='fa fa-copy'></i>
                                Copied
                            </label>
                            <input class="checkbox-tools" type="radio" wire:model="status" value="kiv" name="status" id="tool-6">
                            <label class="for-checkbox-tools" for="tool-6">
                                <i class='fa fa-tags'></i>
                                KIVs <span class="badge badge-dark mb-0">{{ $kivMemo }}</span>
                            </label>
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
                    <div class="text-center pt-2 pr-2 mb-3">
                        <select type="text" wire:model="perpage" name="perpage" class="form-control"
                                style="width:10% !important;display:inline">
                            <option>10</option>
                            <option>20</option>
                            <option>50</option>
                            <option>100</option>
                            <option>200</option>
                        </select>
                        {{--<select type="text" wire:model="searchby" name="searchby" class="form-control"
                                style="width:20% !important;display:inline">
                            <option value="">All</option>
                            <option value="sent">Sent</option>
                            <option value="received">Received</option>
                            <option value="copied">Copied/Minuted</option>
                            <option value="unseen">New</option>
                            <option value="seen">Seen</option>
                            <option value="read">Read</option>
                        </select>--}}
                        <input type="text" wire:model="search" name="search" placeholder="Search"
                               class="form-control inline" style="width:40% !important;display:inline">
                    </div>
                    <table wire:loader.remove wire:poll.60000ms id="table_id" width="100%" class="table table-bordered table-striped"
                           tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
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
                            <tr style="@if($record->isForm()) background:#f1f1e3 @endif {!! $record->kiv() ? 'background:#f1e3e7': ''  !!}" class="animated fadeInLeftBig">
                                <td> {{$loop->index+1 }} </td>
                                <td> {{$record->reference}} </td>
                                <td><a href="{{route('memos.show',$record->id)}}">{{$record->title }}</a></td>
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
                                    {!!  $record->kiv() ? "<i class='fa fa-star'></i>" : "" !!}
                                </td>
                                <td>
                                    {!!  optional($record->lastMinuteTo())->fullname() ?? ($record->raisedFor->fullName() ?? null)  !!}
                                    <br>
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
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
