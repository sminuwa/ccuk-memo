<table class="table table-bordered table-striped">

    @for($i=0;$i<count($permissions);$i++)
        @if($i%4==0)
            <tr>
        @endif
        <td>{{ $permissions[$i]->name }}<input type="checkbox" name="permissions[]" value="{{ $permissions[$i]->id }}" class=""></td>
        @if($i%4==3)
            </tr>
        @endif
    @endfor
        @if($i%3!=0)
        </tr>
        @endif
</table>
