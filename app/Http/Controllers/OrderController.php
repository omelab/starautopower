<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Order;
use App\Delivery;
use App\Ordproduct;
use App\Product;
use App\Option;
use App\User;
use App\SendSMS; 

class OrderController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status='all')
    { 
        $ordsql = Order::with('user', 'delivery');

        if ($status !=='all') { $ordsql->where('status',$status); }
        
        $orders = $ordsql->orderBy('id', 'DESC')->get();  

        return view('admin.order.list')->with('orders', $orders);
    }

    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {

        $orditem = Order::where('id', $id)->first();  

        $user = User::select('name', 'mobile')->where('id', $orditem->user_id)->first();

        $delivery = Delivery::where('id', $orditem->delivery_id)->where('user_id', $orditem->user_id)->first();

        $ordpitem = Ordproduct::where('order_id', $id)->get();
             
        return view('admin.order.details', compact('orditem', 'user', 'delivery', 'ordpitem'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        request()->validate([
            'status' => 'required',
        ]);

        $order = Order::findOrFail($id);

        $order->status  = $request->status;
        

        if ($request->status == 'Complete') { 

            $ordproducts = Ordproduct::select('id', 'product_id', 'optid', 'qty')->where('order_id', '=', $order->id)->get();

            foreach ($ordproducts as $ordproduct) { 
                if ($ordproduct->optid !='') {
                    $option = Option::findOrFail($ordproduct->optid);
                    $option->quantity = $option->quantity - $ordproduct->qty;
                    $option->save();
                }

                $product = Product::findOrFail($ordproduct->product_id);
                $product->stock_qty = $product->stock_qty - $ordproduct->qty;
                $product->save();               
            } 
        }

        $result = $order->save(); 
        $timestamp = strtotime($order->created_at); 
        $date = date('d F, Y', $timestamp); 
        $user = User::select('email', 'mobile')->where('id', $order->user_id)->first(); 
        $delivery = Delivery::findOrFail($order->delivery_id);

        if($result && $request->status == 'Confirm') {
            $msg = 'Your Star Auto Power Order '. $order->order_code .' has been Confirm and will be delivered on your preferred delivery time: '. $delivery->day_slot .' Helpline: 01911861426 ';

            $MSG = new SendSMS(); 
            //mail send
            $MSG->MailSend($user->email, $msg); 
            //message send
            $MSG->MessageSend($user->mobile, $msg); 

            return Redirect::back()->with('success','Order Confirmd successfully');

        }else if($result && $request->status == 'Processing') {
            $msg = 'Your Star Auto Power Order '. $order->order_code .' has been Processing and will be delivered on your preferred delivery time: '. $delivery->day_slot .' Helpline: 01911861426 ';

            $MSG = new SendSMS();
            //mail send
            $MSG->MailSend($user->email, $msg); 
            //message send
            $MSG->MessageSend($user->mobile, $msg); 

            return Redirect::back()->with('success','Order Processing successfully');

        }else if($result && $request->status == 'Complete') {
            $msg = 'Your Star Auto Power Order '. $order->order_code .' has been Complete and will be delivered on your preferred delivery time: '. $delivery->day_slot .' Helpline: 01911861426 ';

            $MSG = new SendSMS();
            //mail send
            $MSG->MailSend($user->email, $msg); 
            //message send
            $MSG->MessageSend($user->mobile, $msg); 

            return Redirect::back()->with('success','Order Completed Successfully');

        }else if($result && $request->status == 'Cancle') {
            $msg = 'Your Star Auto Power Order '. $order->order_code .' has been Cancled if need any query please contact Helpline: 01911861426 ';
            
            $MSG = new SendSMS();
            //mail send
            $MSG->MailSend($user->email, $msg); 
            //message send
            $MSG->MessageSend($user->mobile, $msg); 
            
            return Redirect::back()->with('success','Order Cancled successfully'); 
        }      

        return Redirect::back()->with('error','Something wrong try latar');
    }


    //create new order
    public function new(Request $request)
    {
        return view('admin.order.new');
    }

}
