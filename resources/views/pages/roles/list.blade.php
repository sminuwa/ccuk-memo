@foreach(\App\Models\Role::all() as $role)
    <tr>
        <td>{{$loop->index+1}}</td>
        <td>{{$role->name}}</td>
        <td>
            @if($user->hasRole($role->id))
                <a href="{{route("role.assign",['revoke',$role->id,$user->id])}}" class="btn btn-sm btn-danger">Revoke</a>
            @else
                <a href="{{route("role.assign",['assign',$role->id,$user->id])}}" class="btn btn-sm btn-info">Assign</a>
            @endif
        </td>
    </tr>
@endforeach
