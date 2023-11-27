<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }  
      
    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => transWord('This field is required'),
            'email.email' => transWord('This field must be in an email format'),
            'password.required' => transWord('This field is required'),
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        $notification = array(
			'message' => transWord('Email or password is wrong !!'),
			'alert-type' => 'error'
		);

        return back()->with($notification);  
    }

    // public function registration()
    // {
    //     return view('pages.auth.registration');
    // }
      
    // public function customRegistration(Request $request)
    // {  
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //     ]);
           
    //     $data = $request->all();
    //     $check = $this->create($data);
         
    //     return redirect("dashboard")->withSuccess('You have signed-in');
    // }

    // public function create(array $data)
    // {
    //   return User::create([
    //     'name' => $data['name'],
    //     'email' => $data['email'],
    //     'password' => Hash::make($data['password'])
    //   ]);
    // }    
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('content.dashboard.dashboards-analytics');
        }
  
        $notification = array(
			'message' => transWord('Email or password is wrong !!'),
			'alert-type' => 'error'
		);

        return back()->with($notification);
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
