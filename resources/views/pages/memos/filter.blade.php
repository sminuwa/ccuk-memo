@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div style="float:right">
                        <a href="javascript:history.back()" class="btn btn-warning btn-sm">
                            <span class="fa fa-close"></span> Close
                        </a>
                    </div>
                    <h5 class="card-title">General Memo Search</h5>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form class="form-search" method="post" action="{{ route('memos.filter.search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="toggle">
                                    <input type="radio" name="filter" value="by_sender" id="by_sender" checked="checked"/>
                                    <label for="by_sender">Sender</label>
                                    <input type="radio" name="filter" value="by_receiver" id="by_receiver"/>
                                    <label for="by_receiver">Receiver</label>
                                    <input type="radio" name="filter" value="by_reference" id="by_reference"/>
                                    <label for="by_reference">Reference</label>
                                    <input type="radio" name="filter" value="by_memo" id="by_memo"/>
                                    <label for="by_memo">Entire Memo</label>
                                    <input type="radio" name="filter" value="by_minute" id="by_minute"/>
                                    <label for="by_minute">Minuted</label>
                                </div>
                            </div>
                            <div class="col-lg-6 select-section">
                                <div class="form-group">
                                    <label>FROM</label>
                                    <input type="date" value="{{ $from??"" }}" class="form-control" name="date_from" id="date_from" placeholder="From">
                                </div>
                            </div>
                            <div class="col-lg-6 select-section">
                                <div class="form-group">
                                    <label>TO</label>
                                    <input type="date" value="{{ $to??"" }}" class="form-control" name="date_to" id="date_to" placeholder="To">
                                </div>
                            </div>
                            <div class="col-lg-12 select-section">
                                <div class="form-group">
                                    <label>SEARCH HERE</label>
                                    <input class="form-control" value="{{ $search??"" }}" name="search" id="search" placeholder="Search Here">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-dark btn-sm">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Search Result
                </div>
                <div class="card-body">
                    <div class="loader text-center">

                    </div>
                    <table width="100%" class="table table-bordered table-striped" tag-type="datatable"
                           style="font-size: 13px;color:#5476AA !important;">
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
                        </tr>
                        </thead>
                        <tbody class="result">
                        @if(isset($memos))
                            @forelse ($memos as $memo)
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
                                        {{--                                        {!! $memo->acceptRetirement() ? $memo->retirementStatus().'<br>' :'' !!}--}}
                                        {!! $memo->readStatus() !!}
                                        {!! $memo->hasAttachment() ? "<i class='fa fa-file'></i>" : ""  !!}
                                    </td>
                                    <td>
                                        {!!  optional($memo->lastMinuteTo())->fullname() ?? ($memo->raisedFor->fullName() ?? null)  !!}<br>
                                        <i>{{ $memo->lastMinute()->created_at ?? ($memo->created_at ?? null) }}</i>
                                    </td>

                                </tr>
                            @empty
                                <p>No result</p>
                            @endforelse
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ myAsset('assets/css/tabDesign.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ myAsset('assets/js/tabDesign.js') }}"></script>
    <script>
        $(function () {
            /*$('.form-search').on('submit', function (e) {
                e.preventDefault();
                let filter = $('input[name=filter]:checked').val();
                let search = $('input[name=search]').val();
                let date_from = $('input[name=from]').val();
                let date_to = $('input[name=to]').val();
                $.ajax({
                    url: "{{ route('memos.filter.search') }}",
                    type: "post",
                    data: {
                        filter: filter,
                        search: search,
                        date_from: date_from,
                        date_to: date_to,
                        _token: "{{ @csrf_token() }}"
                    },
                    beforeSend: function () {
                        $('.loader').html("<img src='{{ myAsset('loader.gif') }}' width='100'> ");
                        $('.result').html("");
                    },
                    success: function (response) {
                        console.log(response);
                        $('.loader').html("");
                        $('.result').html(response);
                        $("[tag-type='datatable']").DataTable({
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            retrieve: true
                            // "scrollX": true
                        });
                    },
                    error: function (xhr, error) {
                        console.log(error)
                    }
                });

            });*/


            //initialize the select2 library
            selectTwo('mySelect3')
        });

        $("[tag-type='datatable']").DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // "scrollX": true
        });

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
