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
