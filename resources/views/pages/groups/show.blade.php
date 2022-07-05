@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-md-4">
            <div class="card card-user">
                <div class="image">
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="#">
                            <h5 class="title">{{$record->name}}</h5>
                        </a>
                    </div>
                </div>
                <div class="card-footer">

                    <hr>
                    <div class="button-container">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                        </div>
                        <div class="col-md-3"><h5 class="title">Members</h5></div>
                        <div class="col-md-9 text-right">
                            <form action="{{ route('group.user.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="group_id" value="{{$record->id}}">
                                <select name="users[]" class="form-control mySelect2" multiple>
                                    <option value=""></option>
                                </select>
                                <button class="btn btn-success btn-sm btn-flat">
                                  <span class="btn-label">
                                    <i class="fa fa-user-secret"></i>
                                  </span>
                                    Add Member
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-bordered table-condensed" style="font-size: 13px;">
                        <tr>
                            <th>S/N</th>
                            <th>User</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                        @foreach($staff as $st)
                            <tr>
                                <th>{{ $loop->index+1 }}</th>
                                <td class="text-left"><a href="{{route('users.show',$st->id)}}">{{$st->fullName()}}</a>
                                </td>
                                <td class="text-left">{{ $st->department()->name }}</td>
                                <th>
                                    <form onsubmit="return confirm('Are you sure you want to delete?')"
                                          action="{{route('group.user.destroy',[$st->id,$record->id])}}"
                                          method="post"
                                          style="display: inline">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-outline-secondary btn-sm cursor-pointer">
                                            Delete <i class="text-danger fa fa-remove"></i>
                                        </button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
@endSection

@section('css')
    <style>
        .btn-round {
            border-width: 1px;
            border-radius: 30px;
            padding-right: 23px;
            padding-left: 23px;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function () {
            $('[selectpicker]').selectpicker();
            $("#branch").on('change', function () {
                doDropDown("branch", '{{route('branch.departments')}}', 'GET', {branch_id: $("#branch").val()}, "department", () => {
                }, "Department");

            });

            $("#add-member-link").on('click', function (e) {
                e.preventDefault();
                $("#add-member-modal").modal();
            });

            $('.mySelect2').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'GET',
                    dataType: 'json',
                    url: '{{ route('users.search','staff') }}',
                    data: function (params) {
                        console.log(params);
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        console.log(query);

                        // Query parameters will be ?search=[term]&type=public
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
