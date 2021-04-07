<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Ordproduct;
use App\Product;
use App\Admin;
use App\SendSMS;
use Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status','Complete')->get(); 

        $products = Product::where('status', 1)->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->get();

        $services = Product::where('status', 1)->whereHas('categories', function ($query){  $query->where('slug', 'services'); })->get();

        return view('admin.dashboard',compact('orders','products', 'services'));
    }

    //admin list
    public function adminList()
    {
        $admins = Admin::whereNotIn('id', [1,2])->where('job_title', 'editor')->get();
        return view('admin.user.list',compact('admins'));
    }


    //admin list
    public function addUsers()
    {
        return view('admin.user.register');
    }

    public function storeUsers(Request $request)
    {
        $this->validate($request,[
            'name'      => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins', 
            'password' => 'required|string|min:6|max:10|confirmed', 
        ]); 

        Admin::create([
          'name' => $request->name, 
          'email' => $request->email,
          'job_title' => 'editor',
          'password' => Hash::make($request->password),
        ]);

        Session::flash('flash_message', 'Admin users successfully added!');
        return redirect()->route('admin.list')->with('success', 'New admin users added successfully.');
    }

    //admin list
    public function editUsers(Request $request, $id)
    {
      $data['admin'] = Admin::where('id', $id)->first();
        return view('admin.user.edit',  $data);
    }

    // Remove Users
    public function deleteUsers($id)
    {
      Admin::where('id', $id)->delete();
      return redirect()->route('admin.list')->with('success', 'Admin users deleted successfully.');
    }


    public function updateUsers(Request $request, $id)
    {
        $this->validate($request,[
            'name'    => 'required|string|max:255',  
            'email'   => 'required|string|email|max:255|unique:admins,email,' . $id,
        ]); 

        if (!empty($request->password)) {
          $this->validate($request,[ 
            'password' => 'required|string|min:6|max:10|confirmed', 
          ]); 
        }

        $admin = Admin::findOrFail($id); 

        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if (!empty($request->password)) {
            $admin->password =  Hash::make($request->password);
        }
        
        $admin->save();

        Session::flash('flash_message', 'Admin users successfully updated!');
        return redirect()->route('admin.list')->with('success', 'New admin users updated successfully.');
    }
     
}


