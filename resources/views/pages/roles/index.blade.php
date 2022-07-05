@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Position</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <button class="btn btn-success btn-sm btn-flat" id="add-staff-btn">
                              <span class="btn-label">
                                <i class="fa fa-plus-square"></i>
                              </span>
                                Add Role
                            </button>

                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <table class="table table-bordered table-striped" tag-type="datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Active Members</th>
                            <th>Active Permissions</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td> {{$loop->index+1 }} </td>
                                <td> <a href="{{route('position.show',$record->id)}}">{{$record->name }} &nbsp;  </a></td>
                                <td> <a href="#">{{$record->activeMembers()}}  &nbsp;</a></td>
                                <td> <a href="#">{{$record->activePermissions()}}  &nbsp;</a></td>
                                <td>
                                    <a class="btn btn-outline-secondary btn-sm editP" href="#" role="{{$record->name}}" pid="{{$record->id}}">
                                        Edit
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    <a class="btn btn-outline-secondary btn-sm addPerm" href="#" pid="{{$record->id}}">
                                        Add Permission
                                        <span class="fa fa-plus-circle"></span>
                                    </a>
                                    <form onsubmit="return confirm(' This Role has ( {{$record->activeMembers()}}) Members.Are you sure you want to delete?')"
                                          action="{{route('role.destroy',$record->id)}}"
                                          method="post"
                                          style="display: inline">
                                        {{csrf_field()}}

                                        <button type="submit" class="btn btn-outline-secondary btn-sm cursor-pointer">
                                            Delete<i class="text-danger fa fa-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>

                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-history"></i> Updated 3 minutes ago
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="add-staff-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Position</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('role.store') }}">
                        @csrf
                        <input type="hidden" name="p_id" id="p_id">
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Role</label>
                                    <input type="text" class="form-control" placeholder="Role"
                                           value=""
                                           name="name" id="role">
                                </div>
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

    <div class="modal fade" id="add-permission-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Permission</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('role.permission.assign') }}">
                        @csrf
                        <input type="hidden" name="p_id" id="p_id2">
                        <div class="row" id="permissionNest">

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
            $(".addPerm").on("click",function (e) {
                // role.permissions
                $("#permissionNest").load("{{route("role.permissions",[''])}}/"+$(this).attr('pid'));
                $("#p_id2").val($(this).attr('pid'));
                $("#add-permission-modal").modal();
            });
            $("#add-staff-btn, .editP").on("click",function (e) {
                if($(this).attr('role')){
                    $("#p_id").val($(this).attr('pid'));
                    $("#role").val($(this).attr('role'));
                }else{
                    $("#p_id").val('');
                    $("#role").val('');
                }

                $("#add-staff-modal").modal();
            });
            $("[tag-type='datatable']").DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "scrollX": true
            });
            $("#branch").on('change', function () {
                doDropDown("branch", '{{route('branch.departments')}}', 'GET', {branch_id: $("#branch").val()}, "department", () => {
                }, "Department");

            });


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
