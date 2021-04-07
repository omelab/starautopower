<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{	

	public function __construct()
	{
		$this->middleware('guest:admin', ['except'=>['logout']]);
	}

    public function ShowLoginForm()
    {
    	return view('auth.admin-login');
    }

    public function login(Request $request)
    {
    	//Validate the form data
    	$this->validate($request, [
    		'email'     => 'required|email',
    		'password'  => 'required|min:6'
    	]);

    	//Attempt to log the user in
    	if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
    		//if successfulll, then redirect to their intended location
    		return redirect()->intended(route('admin.dashboard'));
    	}
    	
    	//if unsuccessfull, then back to the login with the form data
    	return redirect()->back()->withInput($request->only('email', 'remamber'))->with('error','Your user name or Password wrong!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
