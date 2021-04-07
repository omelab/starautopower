<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\SendSMS;


class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */

  protected $redirectTo = '/verify';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }


  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'agree'=> 'required',
      'name' => 'required|string|max:255',
      //'email' => 'required|string|email|max:255|unique:users',
      'mobile' => 'required|numeric|digits_between:11,15|unique:users',
      'password' => 'required|string|min:6|max:10|confirmed',
      
      //'mobile_no' => 'required|regex:/[0-9]{10}/|digits:10',
    ]);
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {   
    $this->validator($request->all())->validate(); 
    $cuser = $this->create($request->all());  

    if($cuser->id) {

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

      return redirect()->route('verify')->with('success','Your account created successfully, Please provide your verification code');
    }

    return redirect()->route('register')->with('error','Sorry! You may something mistakes please try again'); // return register page

  }


  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'mobile' => $data['mobile'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }


  /**
   * Load form Verify User OTP Code.
   */
  public function verify()
  {
    //$otp = rand(100000, 999999);
    //$MSG = new SendSMS();
    //$msgResponse = $MSG ->MessageSend('8801966088782', $otp);
    //session()->put('OTP', $otp);
    //echo session()->get('OTP');

    //$path = storage_path() . "/app/public/erresopnse.json";
    //$json = json_decode(file_get_contents($path), true);

    return view('auth.verify'); //->with('otp', session()->get('OTP'));
  }


  /**
   * Check Verifyed Account
   * @param  request $request
   * @return \App\User
   *-------------------------------*/
  public function checkVery(request $request)
  {
    $this->validate($request, [
      'otp' => 'required|numeric',
    ]);

    $otp  = $request->session()->get('OTP');
    $id   = $request->session()->get('cuid');

    if ( $request->otp != $otp ) {
      return redirect()->route('verify')->with('error','Your provided code doesn\'t Match');
    }
    
    if(User::where('id', $id)->update(['isVerified'=>1])){

      $request->session()->forget('OTP');
      $request->session()->forget('cuid');

      return redirect()->route('login')->with('success','Your Account Verifyed successfully');
    }
    return redirect()->route('verify')->with('error','Sorry! You may something mistakes please try again');    
  }

}
