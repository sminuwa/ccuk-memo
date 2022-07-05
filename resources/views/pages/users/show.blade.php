@extends('layouts.app')


@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                <div class="image">
                    <img src="{{ myAsset("assets/img/bg1.jpg") }}" alt="...">
                </div>
                <div class="card-body">
                    <div class="author">
                        <a href="#">
                            <img class="avatar border-dark" src="{{ route("users.profile.img",$record->id) }}"
                                 alt="...">
                            <h5 class="title">{{$record->fullName()}}</h5>
                        </a>
                        <p class="description">
                            {{$record->email}}
                        </p>
                    </div>
                    <p class="description text-center">
                        {{   $record->department()->name ?? null}} <br>
                        {{   $record->branch()->name ?? null}} <br>
                    </p>
                </div>
                <div class="card-footer">

                    <h5 class="text-center">Memo</h5>
                    <hr>
                    <div class="button-container">
                        <div class="row">
                            @php
                                $memoCount =  $record->memoCount();
                            @endphp
                            <div class="col-lg-3 col-md-6 col-6 ml-auto">
                                <h5>{{$memoCount['raised']}}<br><small style="font-size:10px">Raised</small></h5>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6 ml-auto mr-auto">
                                <h5>{{$memoCount['received']}}<br><small style="font-size:10px">Recieved</small></h5>
                            </div>
                            <div class="col-lg-3 mr-auto">
                                <h5>{{$memoCount['copied']}}<br><small style="font-size:10px">Copied</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Office Colleagues</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled team-members">
                        @foreach($colleagues as $colleague)
                        <li>
                            <div class="row">
                                <div class="col-md-2 col-2">
                                    <div class="avatar">
                                        <img src="{{ route("users.profile.img",$colleague->id) }}" alt="Circle Image"
                                             class="img-circle img-no-padding img-responsive">
                                    </div>
                                </div>
                                <div class="col-md-7 col-7">
                                    {{$colleague->fullName()}}
                                    <br>
                                    <span class="text-muted"><small>{{$colleague->department()->name ?? null}}</small></span>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <a href="{{route("users.show",$colleague->id)}}" class="btn btn-sm btn-outline-success btn-round btn-icon"><i
                                            class="fa fa-eye"></i></a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">My Profile</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Signature</a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Password Reset</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    @if(auth()->user()->canAccess('profile.index'))
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6"><h5 class="title">Edit Profile</h5></div>
                                    <div class="col-md-6 text-right">
                                        <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                            <span class="fa fa-close"></span> Close
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('users.update', $record->id) }}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="uxsrrh_ip0dx" value="{{$record->id}}">
                                    <h3>Basic Information</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" name="first_name" id="first_name" value="{{ $user_info->first_name }}" class="form-control" placeholder="First Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="surname" > Surname</label>
                                                <input type="text" name="surname" id="surname" value="{{ $user_info->surname }}" class="form-control" placeholder="Surname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="other_names"> Other Names</label>
                                                <input type="text" name="other_names" id="other_names" value="{{ $user_info->other_names }}" class="form-control" placeholder="Other Names">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Female" {{ $user_info->gender == "Female"?"selected":"" }}>Female</option>
                                                    <option value="Male" {{ $user_info->gender == "Male"?"selected":"" }}>Male</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="marital_status">Marital Status</label>
                                                <select name="marital_status" id="marital_status" class="form-control" required>
                                                    <option value="">Marital Status</option>
                                                    @foreach(marital_status() as $status)
                                                        <option value="{{$status}}" {{ $user_info->marital_status==$status?"selected":'' }}>{{$status}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" value="{{ $record->email }}" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="text" name="phone" id="phone" value="{{ $user_info->phone }}" class="form-control" placeholder="Phone Number" required>
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
                                                        <option value="{{$state->id}}" {{ $user_info->state_of_origin==$state->id?"selected":'' }}>{{$state->name}}</option>
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
                                                        <option value="{{$state->id}}" {{ $user_info->state_of_residence==$state->id?"selected":'' }}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="contact_address">Contact Address</label>
                                                <textarea name="contact_address" id="contact_address" class="form-control" placeholder="Contact Address" required>{{ $user_info->contact_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Employment Information</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" name="username" id="username" value="{{ $record->username }}" class="form-control" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="personnel_number">Personnel No.</label>
                                                <input type="text" name="personnel_number" id="personnel_number" value="{{ $user_info->personnel_number }}" class="form-control" placeholder="Personnel Number">
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
                                                        <option value="{{$qualification->id}}" {{ $user_info->entry_qualification==$qualification->id?"selected":"" }}>{{$qualification->name}}</option>
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
                                                        <option value="{{$qualification->id}}" {{ $user_info->highest_qualification==$qualification->id?"selected":"" }}>{{$qualification->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="branch_id">Faculty</label>
                                                <select name="branch_id" id="branch_id" class="form-control" required>
                                                    <option value="">Select Faculty</option>
                                                    @php $branches = \App\Models\Branch::orderBy('name', 'asc')->get() @endphp
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}" {{ $user_info->branch_id==$branch->id?"selected":"" }}>{{$branch->name}}</option>
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
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->id}}" {{ $user_info->department_id==$department->id?"selected":"" }}>{{$department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="position_id">Position</label>
                                                <select name="position_id" id="position_id" required class="form-control">
                                                    <option value="">Select Position</option>
                                                    @php $positions = \App\Models\Position::orderBy('name', 'asc')->get() @endphp
                                                    @foreach($positions as $position)
                                                        <option value="{{$position->id}}" {{ $user_info->position_id==$position->id?"selected":"" }}>{{$position->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <div class="form-group">
                                                <button class="btn btn-info btn-sm">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6"><h5 class="title">Edit Profile</h5></div>
                                    <div class="col-md-6 text-right">
                                        <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                            <span class="fa fa-close"></span> Close
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('users.update', $record->id) }}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="uxsrrh_ip0dx" value="{{$record->id}}">
                                    <h3>Basic Information</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input readonly type="text" name="first_name" id="first_name" value="{{ $user_info->first_name }}" class="form-control" placeholder="First Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="surname" > Surname</label>
                                                <input readonly type="text" name="surname" id="surname" value="{{ $user_info->surname }}" class="form-control" placeholder="Surname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="other_names"> Other Names</label>
                                                <input readonly type="text" name="other_names" id="other_names" value="{{ $user_info->other_names }}" class="form-control" placeholder="Other Names">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select readonly name="gender" id="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Female" {{ $user_info->gender == "Female"?"selected":"" }}>Female</option>
                                                    <option value="Male" {{ $user_info->gender == "Male"?"selected":"" }}>Male</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="marital_status">Marital Status</label>
                                                <select readonly name="marital_status" id="marital_status" class="form-control" required>
                                                    <option value="">Marital Status</option>
                                                    @foreach(marital_status() as $status)
                                                        <option value="{{$status}}" {{ $user_info->marital_status==$status?"selected":'' }}>{{$status}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input readonly type="email" name="email" id="email" value="{{ $record->email }}" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input readonly type="text" name="phone" id="phone" value="{{ $user_info->phone }}" class="form-control" placeholder="Phone Number" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state_of_origin">State of Origin</label>
                                                <select readonly name="state_of_origin" id="state_of_origin" class="form-control" required>
                                                    <option value="">State of Origin</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" {{ $user_info->state_of_origin==$state->id?"selected":'' }}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state_of_residence">State of Residence</label>
                                                <select readonly name="state_of_residence" id="state_of_residence" class="form-control" required>
                                                    <option value="">State of Residence</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" {{ $user_info->state_of_residence==$state->id?"selected":'' }}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="contact_address">Contact Address</label>
                                                <textarea readonly name="contact_address" id="contact_address" class="form-control" placeholder="Contact Address" required>{{ $user_info->contact_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Employment Information</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input readonly type="text" name="username" id="username" value="{{ $record->username }}" class="form-control" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="personnel_number">Personnel No.</label>
                                                <input readonly type="text" name="personnel_number" id="personnel_number" value="{{ $user_info->personnel_number }}" class="form-control" placeholder="Personnel Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="entry_qualification">Entry Qualification</label>
                                                <select readonly name="entry_qualification" id="entry_qualification" class="form-control">
                                                    <option value="">Entry Qualification</option>
                                                    @foreach($qualifications as $qualification)
                                                        <option value="{{$qualification->id}}" {{ $user_info->entry_qualification==$qualification->id?"selected":"" }}>{{$qualification->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="highest_qualification">Highest Qualification</label>
                                                <select readonly name="highest_qualification" id="highest_qualification" class="form-control">
                                                    <option value="">Highest Qualification</option>
                                                    @foreach($qualifications as $qualification)
                                                        <option value="{{$qualification->id}}" {{ $user_info->highest_qualification==$qualification->id?"selected":"" }}>{{$qualification->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="branch_id">Branch</label>
                                                <select readonly name="branch_id" id="branch_id" class="form-control" required>
                                                    <option value="">Select Branch</option>
                                                    @php $branches = \App\Models\Branch::orderBy('name', 'asc')->get() @endphp
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}" {{ $user_info->branch_id==$branch->id?"selected":"" }}>{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="department_id">Department</label>
                                                <select readonly name="department_id" id="department_id" class="form-control" required style="height: auto;">
                                                    <option value="">Select Department</option>
                                                    @php $departments = \App\Models\Department::orderBy('name', 'asc')->get() @endphp
                                                    @foreach($departments as $department)
                                                        <option value="{{$department->id}}" {{ $user_info->department_id==$department->id?"selected":"" }}>{{$department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="position_id">Position</label>
                                                <select readonly name="position_id" id="position_id" required class="form-control">
                                                    <option value="">Select Position</option>
                                                    @php $positions = \App\Models\Position::orderBy('name', 'asc')->get() @endphp
                                                    @foreach($positions as $position)
                                                        <option value="{{$position->id}}" {{ $user_info->position_id==$position->id?"selected":"" }}>{{$position->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><h5 class="title">Signature</h5></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('users.signature.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="uxsrrh_ip0dx" value="{{$record->id}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(auth()->user()->signature())
                                            <img src="{{ myAsset('signatures/'.auth()->user()->signature()[0]->name) }}" width="100">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <input type="file" name="signature">
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="form-group">
                                            <button class="btn btn-info btn-sm" style="margin:0;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6"><h5 class="title">Reset My Password</h5></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('users.password.reset') }}">
                                @csrf
                                <input type="hidden" name="uxsrrh_ip0dx" value="{{$record->id}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" class="form-control" placeholder="Current Password" style="height: auto;"
                                                   name="currentPassword">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" placeholder="New Password" style="height: auto;"
                                                   name="newPassword">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Confirm Password" style="height: auto;"
                                                   name="confirmPassword">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-info btn-sm" style="margin:0;">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(auth()->user()->canAccess('profile.index'))
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6"><h5 class="title">Create New Password</h5></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('users.password.reset') }}">
                                    @csrf
                                    <input type="hidden" name="uxsrrh_ip0dx" value="{{$record->id}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" placeholder="New Password" style="height: auto;"
                                                       name="newPassword">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Confirm Password" style="height: auto;"
                                                       name="confirmPassword">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button class="btn btn-info btn-sm" style="margin:0;">Reset Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
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
        /*$(function () {
            $('[selectpicker]').selectpicker();
            $("#branch").on('change', function () {
                doDropDown("branch", '{{route('branch.departments')}}', 'GET', {branch_id: $("#branch").val()}, "department", () => {
                }, "Department");

            });
        });*/

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
