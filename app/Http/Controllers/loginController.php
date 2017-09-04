<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/*
class loginController extends Controller
{
    public function login(Request $request)
    {

       // $auftrag = auftrag::where('auftragID',1)->get();
       // dd($auftrag);
        $user = User::find('admin');
        $user->name='wangxun';
        $user->update();
        dd($user);
    }
}*/


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
/*
class loginController extends BaseController
{
    public function login(Request $request)
    {
    	$username = $request->input('username');
    	$password = $request->input('password');

    	//$checklogin = DB::table('users')->where(['username'=>$username,'password'=>$password])->get();

    	if (count($checklogin) > 0)
    	{
    		return view('dashboard');
    	}
    	else
    	{
    		return back() -> with('message','Benutzername oder Passwort ist ungültig, versuchen Sie bitte erneut!');
    		// return \Redirect::route('loginpage')->withInput()->with('message','');
       	}
    }

    public function logout()
    {
    if (Auth::check()) {
        Auth::logout();
    }
    return \Redirect::route('loginpage');
	}
}
 
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);