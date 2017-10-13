<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class loginController extends Controller
{
    public function login(Request $request)
    {

        $email = $request->input('username');
        $password = $request->input('password');
        
        if (Auth::attempt(['email'=>$email, 'password'=>$password]))
        {
            return view('dashboard');
        }

        
        return back() -> with('message','Benutzername oder Passwort ist ungültig, versuchen Sie bitte erneut!');
    }
}