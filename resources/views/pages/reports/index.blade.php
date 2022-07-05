@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="card ">
                <div class="card-header">
                    <div style="float:right">
                        <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                            <span class="fa fa-close"></span> Close
                        </a>
                    </div>
                    <h5 class="card-title">General Reports</h5>
                </div>
                <div class="card-body ">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="post" action="{{ route('reports.load') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="toggle">
                                    <input type="radio" name="report_by" value="staff" id="staff_option" checked="checked"/>
                                    <label for="staff_option">Staff</label>
                                    <input type="radio" name="report_by" value="department" id="department_option"/>
                                    <label for="department_option">Departments</label>
                                </div>
                            </div>
                            <div class="col-lg-6 select-section">
                                <div class="form-group">
                                    <label>SELECT STAFF</label>
                                    <select class="form-control mySelect3" name="staff" id="staff">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>SELECT TYPE</label>
                                <div class="toggle">
                                    <input type="radio" name="report_type" value="{{ \App\Models\Memo::TYPE_MEMO }}" id="memo" checked="checked"/>
                                    <label for="memo">Memo</label>
                                    <input type="radio" name="report_type" value="{{ \App\Models\Memo::TYPE_FORM }}" id="form"/>
                                    <label for="form">Form</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-dark btn-sm">Load Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="row" id="report-section">
        <div class="col-md-12">
            @if(isset($reportType)  && $reportType == \App\Models\Memo::TYPE_MEMO)
                <section>
                    <div class="tabs tabs-style-flip">
                        <nav>
                            <ul>
                                <li><a style="text-decoration: none !important;" href="#section-flip-1"><i class="nc-icon nc-chart-pie-36"></i> <span>Two Hours Memos <br>({{ $memos2h->count() }})</span></a></li>
                                <li><a style="text-decoration: none !important;" href="#section-flip-4"><i class="nc-icon nc-chart-pie-36"></i> <span>Two Days Memos <br>({{ $memos2d->count() }})</span></a></li>
                                <li><a style="text-decoration: none !important;" href="#section-flip-2"><i class="nc-icon nc-chart-pie-36"></i> <span>One Week Memos <br>({{ $memos1w->count() }})</span></a></li>
                                <li><a style="text-decoration: none !important;" href="#section-flip-3"><i class="nc-icon nc-chart-pie-36"></i> <span>All Memo <br>({{ $memos->count() }})</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-flip-1">
                                <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
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
                                    @foreach($memos2h as $memo)
                                        <tr style="@if($memo->isForm()) background:#f1f1e3 @endif">
                                            <td> {{$loop->index+1 }} </td>
                                            <td> {{$memo->reference}} </td>
                                            <td> <a href="{{route('memos.show',$memo->id)}}">{{$memo->title }}</a></td>
                                            <td>
                                                @if($memo->raisedBy->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedBy->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($memo->raisedFor->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedFor->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td> {{ date('M jS, Y', strtotime($memo->date_raised)) }} </td>
                                            <td>
                                                {{$memo->type }} ({{ $memo->status }})<br>
                                                {!! $memo->acceptRetirement() ? $memo->retirementStatus().'<br>' :'' !!}
                                                {!! $memo->readStatus() !!}
                                                {!! $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                            </td>
                                            <td>
                                                {!!  optional($memo->lastMinuteTo())->fullname() ?? ($memo->raisedFor->fullName() ?? null)  !!}<br>
                                                <i>{{ $memo->lastMinute()->created_at ?? ($memo->created_at ?? null) }}</i>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
                            <section id="section-flip-2">
                                <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
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
                                    @foreach($memos2d as $memo)
                                        <tr style="@if($memo->isForm()) background:#f1f1e3 @endif">
                                            <td> {{$loop->index+1 }} </td>
                                            <td> {{$memo->reference}} </td>
                                            <td> <a href="{{route('memos.show',$memo->id)}}">{{$memo->title }}</a></td>
                                            <td>
                                                @if($memo->raisedBy->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedBy->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($memo->raisedFor->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedFor->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td> {{ date('M jS, Y', strtotime($memo->date_raised)) }} </td>
                                            <td>
                                                {{$memo->type }} ({{ $memo->status }})<br>
                                                {!! $memo->acceptRetirement() ? $memo->retirementStatus().'<br>' :'' !!}
                                                {!! $memo->readStatus() !!}
                                                {!! $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                            </td>
                                            <td>
                                                {!!  optional($memo->lastMinuteTo())->fullname() ?? ($memo->raisedFor->fullName() ?? null)  !!}<br>
                                                <i>{{ $memo->lastMinute()->created_at ?? ($memo->created_at ?? null) }}</i>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
                            <section id="section-flip-3">
                                <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
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
                                    @foreach($memos1w as $memo)
                                        <tr style="@if($memo->isForm()) background:#f1f1e3 @endif">
                                            <td> {{$loop->index+1 }} </td>
                                            <td> {{$memo->reference}} </td>
                                            <td> <a href="{{route('memos.show',$memo->id)}}">{{$memo->title }}</a></td>
                                            <td>
                                                @if($memo->raisedBy->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedBy->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($memo->raisedFor->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedFor->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td> {{ date('M jS, Y', strtotime($memo->date_raised)) }} </td>
                                            <td>
                                                {{$memo->type }} ({{ $memo->status }})<br>
                                                {!! $memo->acceptRetirement() ? $memo->retirementStatus().'<br>' :'' !!}
                                                {!! $memo->readStatus() !!}
                                                {!! $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                            </td>
                                            <td>
                                                {!!  optional($memo->lastMinuteTo())->fullname() ?? ($memo->raisedFor->fullName() ?? null)  !!}<br>
                                                <i>{{ $memo->lastMinute()->created_at ?? ($memo->created_at ?? null) }}</i>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
                            <section id="section-flip-4">
                                <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
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
                                    @foreach($memos as $memo)
                                        <tr style="@if($memo->isForm()) background:#f1f1e3 @endif">
                                            <td> {{$loop->index+1 }} </td>
                                            <td> {{$memo->reference}} </td>
                                            <td> <a href="{{route('memos.show',$memo->id)}}">{{$memo->title }}</a></td>
                                            <td>
                                                @if($memo->raisedBy->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedBy->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($memo->raisedFor->id == auth()->id())
                                                    Me
                                                @else
                                                    <a href="{{route('memos.show',$memo->id)}}">
                                                        {{ $memo->raisedFor->fullName() }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td> {{ date('M jS, Y', strtotime($memo->date_raised)) }} </td>
                                            <td>
                                                {{$memo->type }} ({{ $memo->status }})<br>
                                                {!! $memo->acceptRetirement() ? $memo->retirementStatus().'<br>' :'' !!}
                                                {!! $memo->readStatus() !!}
                                                {!! $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                            </td>
                                            <td>
                                                {!!  optional($memo->lastMinuteTo())->fullname() ?? ($memo->raisedFor->fullName() ?? null)  !!}<br>
                                                <i>{{ $memo->lastMinute()->created_at ?? ($memo->created_at ?? null) }}</i>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
                        </div><!-- /content -->
                    </div><!-- /tabs -->
                </section>
            @endif
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ myAsset('assets/css/tabDesign.css') }}" rel="stylesheet">
@endsection

@push('js')
    <script src="{{ myAsset('assets/js/tabDesign.js') }}"></script>
    <script>
        $(function () {

            $.ajax({
                url:"",
                type: "post",
                data: {

                    _token: "{{ @csrf_token() }}"
                },
                beforeSend: function(data){
                    console.log(data);
                },
                success: function(response){
                    console.log(response)
                },
                error: function(xhr, error){
                    console.log(error)
                }
            });



            $('#department_option').click(function () {
                $('.select-section').html(department);
            });

            $('#staff_option').click(function () {
                $('.select-section').html(staff);
                selectTwo('mySelect3')
            });

            //initialize the select2 library
            selectTwo('mySelect3')
        });

        let staff = `
            <div class="form-group">
                <label>SELECT STAFF</label>
                <select class="form-control mySelect3" name="staff" id="staff">
                </select>
            </div>
        `;
        let department = `
            <div class="form-group">
                @php $departments = \App\Models\Department::all(); @endphp
                <label>SELECT DEPARTMENT</label>
                <select class="form-control" name="department" id="department">
                    <option></option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        `;
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
    </script>
@endpush
