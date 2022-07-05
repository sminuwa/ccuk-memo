<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    //

    public function showLogin()
    {
        return view('pages.auth.index');
    }

    public function login(Request $request)
    {

        $this->validate($request,[
            "username"=>"required",
            "password"=>"required"
        ]);

        $check = User::where(['username'=>$request->username, 'status'=>User::STATUS_ACTIVE])->first();

        if(!$check) {
            return back()->withErrors(["message" => "This user has been disabled"]);
        }
        $credentials = ["username"=>$request->username,"password"=>$request->password];
        if(Auth::guard("web")->attempt($credentials,0)){
            return redirect()->intended(route("memos.index"));
        }
        return redirect()->back()->withErrors(["message"=>"Invalid Login Credentials"]);
    }

    public function logout(Request $request)
    {
        Auth::guard("web")->logout();
        $request->session()->invalidate();
        return redirect("/");
    }
}
