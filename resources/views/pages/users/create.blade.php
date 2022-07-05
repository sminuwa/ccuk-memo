@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Create new Users</h5>
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
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
                    <form method="post" action="{{ route('users.store') }}">
                        @csrf
                        <h3>Basic Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="surname" > Surname</label>
                                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Surname" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="other_names"> Other Names</label>
                                    <input type="text" name="other_names" id="other_names" class="form-control" placeholder="Other Names">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Female" >Female</option>
                                        <option value="Male" >Male</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="marital_status">Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-control" required>
                                        <option value="">Marital Status</option>
                                        @foreach(marital_status() as $status)
                                            <option value="{{$status}}" >{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state_of_origin">State of Origin</label>
                                    <select name="state_of_origin" id="state_of_origin" class="form-control" required>
                                        <option value="">State of Origin</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" >{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state_of_residence">State of Residence</label>
                                    <select name="state_of_residence" id="state_of_residence" class="form-control" required>
                                        <option value="">State of Residence</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" >{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact_address">Contact Address</label>
                                    <textarea name="contact_address" id="contact_address" class="form-control" placeholder="Contact Address" required></textarea>
                                </div>
                            </div>
                        </div>
                        <h3>Employment Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="personnel_number">Personnel No.</label>
                                    <input type="text" name="personnel_number" id="personnel_number" class="form-control" placeholder="Personnel Number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="entry_qualification">Entry Qualification</label>
                                    <select name="entry_qualification" id="entry_qualification" class="form-control">
                                        <option value="">Entry Qualification</option>
                                        @foreach($qualifications as $qualification)
                                            <option value="{{$qualification->id}}" >{{$qualification->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="highest_qualification">Highest Qualification</label>
                                    <select name="highest_qualification" id="highest_qualification" class="form-control">
                                        <option value="">Highest Qualification</option>
                                        @foreach($qualifications as $qualification)
                                            <option value="{{$qualification->id}}" >{{$qualification->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">Select Branch</option>
                                        @php $branches = \App\Models\Branch::orderBy('name', 'asc')->get() @endphp
                                        @foreach($branches as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control" required style="height: auto;">
                                        <option value="">Select Department</option>
                                        @php $departments = \App\Models\Department::orderBy('name', 'asc')->get() @endphp
                                        @foreach($departments as $d)
                                            <option value="{{$d->id}}">{{$d->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <label for="position_id">Position</label>
                                    <select name="position_id" id="position_id" required class="form-control">
                                        <option value="">Select Position</option>
                                        @php $positions = \App\Models\Position::orderBy('name', 'asc')->get() @endphp
                                        @foreach($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endSection


@push('css')
    <style>
        span.relative svg {
            width: 14px;
            height: 14px;
        }

        table tr a{
            color:#0c2646;
        }
    </style>
@endpush

@section('js')

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
