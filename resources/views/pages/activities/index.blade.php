@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Activity Log</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <table class="table table-bordered table-striped" tag-type="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>By</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td> {{$loop->index+1 }} </td>
                                <td> {{ $activity->causer->fullName() }} </td>
                                <td> {{ $activity->description }} </td>
                                <td> {{ $activity->created_at }} </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

@endSection


@section('css')
    <style>
        span.relative svg {
            width: 14px;
            height: 14px;
        }

        table tr a{
            color:#0c2646;
        }
    </style>
@endsection

@section('js')

    <script>
        $(document).ready(function () {

            $("[tag-type='datatable']").DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "scrollX": true
            });
        });
    </script>
@endsection
