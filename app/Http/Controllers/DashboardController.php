<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(["auth","permission"]);
    }

    public function index(Request $request)
    {
        return view("pages.dashboard.index");
    }

    public function forms(){
        return view('forms.dashboard.index');
    }
}
