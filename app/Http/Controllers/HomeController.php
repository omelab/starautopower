<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Order;
use App\Delivery;
use App\Ordproduct;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('profile');
    }

    public function order()
    {
        $uid = Auth::user()->id; 
        $order= Order::where('user_id', $uid)->orderBy('id', 'DESC')->get();
        return view('order.index')->with('orderInfo', $order);
    }

    public function showOrder($id) 
    {
        $uid = Auth::user()->id; 
        $orditem = Order::where('id', $id)->where('user_id', $uid)->first(); 

        if (empty($orditem)) {
            return redirect()->route('home')
            ->with('error','You have no order item now');
        }

        $user = User::select('name', 'mobile')->where('id', $orditem->user_id)->first();

        $delivery = Delivery::where('id', $orditem->delivery_id)->where('user_id', $orditem->user_id)->first();

        $ordpitem = Ordproduct::where('order_id', $id)->get();
             
        return view('order.details', compact('orditem','user','delivery','ordpitem'));
    }

    public function updateOrder(Request $request, $id)
    {
        request()->validate([
            'status' => 'required',
        ]);

        $order = Order::findOrFail($id);

        $order->status  = $request->status;

        $order->save();   

        return Redirect::back()->with('success','Your order has been canceled now');

    }
    
}
