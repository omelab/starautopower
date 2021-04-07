<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\SendSMS;

class PasswordController extends Controller
{
   /*
   |--------------------------------------------------------------------------
   | Password Reset Controller
   |--------------------------------------------------------------------------
   |
   | This controller is responsible for handling password reset requests
   | and uses a simple trait to include this behavior. You're free to
   | explore this trait and override any methods you wish to tweak.
   |
   */

   use ResetsPasswords;

   /**
    * Create a new password controller instance.
    *
    * @return void
    */
	public function __construct()
	{
	  //$this->middleware('guest');
	}

    //display form input mobile number
    public function showOtpRequestForm()
    {
        return view('auth.passwords.otp');
    }


    //send otp code and check functionality
    public function sendOtpCode(Request $request)
    {

    	$this->validate($request, [
        'mobile' => 'required|regex:/(01)[0-9]{9}/',
        //'email' => 'required',
      ]);

      //get user data by email 
    	$cuser = User::where('mobile', $request->mobile)->first();

      //redirect when not find any user data
      if(empty($cuser)) {
        return redirect()->route('password.request')->with('error','Sorry! we can\'t find any account through this mobile number, you can create new account');
      }

      if((time()-strtotime($cuser->updated_at)) < 10800){
        return redirect()->route('password.request')->with('error','Sorry! you have change password recently, you can change it after 3 hours.');
      };
           

	    if(!empty($cuser)) {

        $mobile = '+88'.$request->mobile;

	      $otp = rand(1000, 9999);

	      $msg = 'Star Auto Power 4 digit verification PIN is '. $otp .' Please try shopping to save money.';

        $MSG = new SendSMS();
        $MSG->MailSend($cuser->email, $msg);

        $msgResponse = $MSG->MessageSend($cuser->mobile, $msg); 

        $response = json_decode($msgResponse, true);

        //remove old key
        $request->session()->forget(['OTP', 'cuid']);

        //store new key
        $request->session()->put('OTP', $otp);
        $request->session()->put('cuid', $cuser->id);
  
	      return redirect()->route('password.change')
            ->with('success','You have received a token number, Please provide this token and change your password');
	    }

	    return redirect()->route('password.request')->with('error','Sorry! something wrong, please try after some times');
    }

    public function showResetForm(request $request)
    {
      if (!$request->session()->exists('OTP')) {
        return redirect()->route('password.request')->with('error','Sorry! something wrong, please try after some times');
      }
    	return view('auth.passwords.change');
    }

    public function passChange(request $request)
    {
      $this->validate($request, [
        'token'     => 'required|numeric',
        'rpassword' => 'required|confirmed|min:6',
      ]);

      $otp  = $request->session()->get('OTP');
      $id   = $request->session()->get('cuid');

      if ( $request->token != $otp ) {
        return redirect()->route('password.change')->with('error','Your provided code doesn\'t Match');
      }
       
      $token    =  $request->token;
      $password =  $request->rpassword;

      $user = User::findOrFail($id);      
      $user->password = Hash::make($password);
       
      if( $user->save() ){
        $request->session()->forget('OTP');
        $request->session()->forget('cuid');

        if (Auth::user()) {
          return redirect()->route('logout')->with('success','Your Password has been changed successfully, you can login now');
        }
        
        return redirect()->route('login')->with('success','Your Password has been changed successfully, you can login now');
      }
      return redirect()->route('verify')->with('error','Sorry! You may something mistakes please try again'); 
    }
}
