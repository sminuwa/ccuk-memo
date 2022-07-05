@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{--                    {{ \App\Models\User::find(auth()->id())->referenceCode() }}--}}
                    {{--                    {{ \App\Models\Memo::getLastMemo() }}--}}
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">My Messages</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="#" class="btn btn-success btn-sm btn-flat" id="add-message-btn">
                              <span class="btn-label">
                                <i class="nc-icon nc-paper"></i>
                              </span>
                                Create New
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
                    <div class="table-responsive">
                        <table id="table_id" width="100%" class="table table-bordered table-striped" tag-type="datatable" style="font-size: 13px;color:#5476AA !important;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Message</th>
                                <th>Category</th>
                                <th class="text-right" width="200"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <td> {{ $loop->index+1 }} </td>
                                    <td> {{ $message->message}} </td>
                                    <td> {{ $message->category->name ?? "General" }} </td>
                                    <td class="text-right">
                                        <a href="javascript:;" class="btn btn-outline-secondary btn-sm editM" message="{{$message->message}}" category="{{$message->department_id}}" mid="{{$message->id}}">
                                            Edit
                                        </a>
                                        <form onsubmit="return confirm('Are you sure you want to delete?')"
                                              action="{{route('messages.destroy',$message->id)}}"
                                              method="post"
                                              style="display: inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm cursor-pointer">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-message-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Custom Messages</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('messages.store') }}">
                        @csrf
                        <input type="hidden" name="m_id" id="m_id">
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label>Message</label>
                                    <input type="text" class="form-control" placeholder="Message" style="height: auto;"
                                           value=""
                                           name="message" id="message">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    @php $categories = \App\Models\Department::orderBy('name', 'asc')->get(); @endphp
                                    <label>Category</label>
                                    <select type="text" class="form-control" style="height: auto;"
                                           name="category" id="category">
                                        <option value="0">General</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
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
@endsection


@push('js')
    <script>
        $(document).ready(function(){
            $('#add-message-btn, .editM').on('click', function(){
                if($(this).attr('message')) {
                    $('#m_id').val($(this).attr('mid'));
                    $('#message').val($(this).attr('message'));
                    $('#category').val($(this).attr('category'));
                }else{
                    $('#m_id').val('');
                    $('#message').val('');
                    $('#category').val('');
                }
                $('#add-message-modal').modal();
            })
            $('#table_id').DataTable();
        });
    </script>
@endpush
