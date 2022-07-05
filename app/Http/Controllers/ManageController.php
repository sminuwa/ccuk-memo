<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Group;
use App\Models\Location;
use App\Models\Message;
use App\Models\Position;
use App\Models\Role;
use App\Models\Route;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    //
    public function index(){
        $branches = Branch::count();
        $departments = Department::count();
        $positions = Position::count();
        $groups = Group::count();
        $roles = Role::count();
        $vehicles = Vehicle::count();
        $locations = Location::count();
        $routes = Route::count();
        $messages = Message::where('user_id',auth()->id())->count();
        $staff = User::count();
        return view('pages.manage.index',
            compact(
                'branches',
                'departments',
                'positions',
                'groups',
                'roles',
                'locations',
                'vehicles',
                'routes',
                'messages',
                'staff'
            ));
    }
}
