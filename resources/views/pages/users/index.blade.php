@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Users</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm btn-flat">
                              <span class="btn-label">
                                <i class="fa fa-user-plus"></i>
                              </span>
                                Add Staff
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-success">{{ session('error') }}</div>
                    @endif
                    <table class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Branch</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="@if($user->status == 'inactive') bg-warning text-white @endif">
                                <td> {{$loop->index+1 }} </td>
                                <td> <a href="{{route('users.show',$user->id)}}">{{ $user->details()?->personnel_number }}</a></td>
                                <td> <a href="{{route('users.show',$user->id)}}">{{ $user->fullName() }}</a></td>
                                <td> <a href="{{route('users.show',$user->id)}}">{{ $user->details()?->department?->name }}</a></td>
                                <td> <a href="{{route('users.show',$user->id)}}">{{ $user->details()?->branch?->name }}</a> </td>
                                <td>
                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('users.show',$user->id)}}">
                                        View <span class="fa fa-eye"></span>
                                    </a>
                                    <a class="btn btn-outline-secondary btn-sm assign-role-link" u-id="{{$user->id}}">
                                        Role <span class="fa fa-plus-square"></span>
                                    </a>
                                    <a class="btn btn-outline-secondary btn-sm" href="{{route('users.status',$user->id)}}">
                                         @if($user->status == 'active') Deactivate @else Activate @endif <span class="fa fa-lock"></span>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="assign-role-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assign Role</h4>
                </div>
                <div class="modal-body">
                    <form method="post" >
                        @csrf

                        <input type="hidden" name="u_id" id="u_id">
                        <div class="row">
                            <div class="col-md-12 pr-1">

                                <table class="table table-bordered table-stripped">
                                    <tr>
                                        <th>SN</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    <tbody id="roleBody">

                                    </tbody>

                                </table>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">Save</button>
                                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </form>
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
            //alert('df');
            $("#add-staff-btn").on("click",function (e) {
                $("#add-staff-modal").modal();
            });
            $(".assign-role-link").on("click",function (e) {
                u_id=$(this).attr('u-id');
                console.log('{{ route("role.list",['']) }}/'+u_id);
                $.ajax({
                    url:'{{ route("role.list",['']) }}/'+u_id,
                    type:'GET',
                    success:function (response) {
                        $("#roleBody").html(response);
                    }
                });

                $("#assign-role-modal").modal();
            });
            $("[tag-type='datatable']").DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "scrollX": true
            });

            /*$("#branch").on('change', function () {
                doDropDown("branch", '{{route('branch.departments')}}', 'GET', {branch_id: $("#branch").val()}, "department", () => {
                }, "Department");

            });*/




        });

        function doDropDown(id, url, type, data, childId, callback, dropdownName) {

            $.ajax({
                type: type,
                data: data,
                url: url,
                success: function (response) {
                    // $(childId).empty()
                    label = dropdownName ? dropdownName : capitalizeFLetter(childId);
                    html = "<option value=''>Select " + label + "</option>";
                    $.each(response, function (index, value) {
                        html += "<option value='" + value.id + "'>" + value.name + "</option>"

                    });
                    $("#" + childId).html(html);
                    if (callback)
                        callback();
                }
            });
        }
    </script>
@endsection
