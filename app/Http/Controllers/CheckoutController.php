<?php
namespace App\Http\Controllers;
use Session;
use Cart;
use App\Checkout;
use App\Http\Requests; // request method
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Area;
use App\Order;
use App\Delivery;
use App\Ordproduct;
use App\Timelist;
use App\SendSMS;
use Validator;
use App\Product; // Product
use App\Option; // Product Options

class CheckoutController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Cart::count() < 1) {
            return redirect()->route('home')
            ->with('error','You have not cart item now');
        }
 
        $time = array();
        $user_id  = Auth::user()->id;
        $deliveryInfo = Delivery::where('user_id', $user_id )->where('status', 1)->first();

        $charge = 50;
       
        /*$arid = session('s_area') !== null ? session('s_area')->id : ($this->arId($deliveryInfo->area) !== null ? $this->arId($deliveryInfo->area): '');*/

        if($deliveryInfo){
            $arid = $this->arId($deliveryInfo->area) !== null ? $this->arId($deliveryInfo->area): '';
            $deliveryInfo->area_id =  $arid;
            $artime = json_decode($this->arTime($arid));
            if ($artime) {
                $timelist = Timelist::whereIn('id', $artime)->get();
                foreach ($timelist as $tmlist) {
                    $time[$tmlist->time_key] = $tmlist->time_val;
                } 
            }            
            $charge = Area::where('id', $arid)->first()->delivery_charge;
        }

        $area = Area::where('status', 1)->pluck('title', 'id');
   
        return view('checkout.index', compact('deliveryInfo', 'area', 'time', 'charge'));
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'delivery_id'       => 'required|integer',
            'day_slot'          => 'required',
            //'time_slot'         => 'required',
            'delivery_charge'   => 'required',
        ]);

        //Save Delivery information
        $delivery = Delivery::findOrFail($request->delivery_id);
        $delivery->day_slot     = $request->input('day_slot').' '. date('Y');
        //$delivery->time_slot    = $request->input('time_slot');       
        $delivery->save();

        $exist = Order::orderBy('id', 'desc')->first();  
        $ord = intval($exist->order_code??0) + 1;
        $order_code = sprintf("%06d", $ord);

        //save order information
        $order = new Order(); 
        $order->user_id             = Auth::user()->id; 
        $order->order_code          = $order_code; 
        $order->delivery_id         = $request->input('delivery_id');
        $order->payment_method      = 'Cash on Delivery'; 
        $order->amount              = Cart::total(0, false, false);
        $order->delivery_charge     = $request->input('delivery_charge');
        $order->comments            = $request->input('comments');
        $order->status              = 'Pending';
        $order->save();

        //save order Product information
        $cartItems = Cart::content();
        foreach ($cartItems as $item) {
             if ( $item->options->has('optid') ) {
                $option = Option::findOrFail( $item->options->optid ); 
                $data['optid']  = $item->options->optid;
                $data['size']   = $option->size;
                $data['color']  = $option->color;
            }

            $data['order_id']   = $order->id;
            $data['product_id'] = $item->id;            
            $data['name']       = $item->name;
            $data['image']      = $item->options->image;
            $data['qty']        = $item->qty;
            $data['price']      = $item->price;
            $data['regprice']   = $item->options->regprice;

            Ordproduct::create($data);

        }

        $timestamp = strtotime($order->created_at);
        $date = date('d F, Y', $timestamp);

        $user = User::select('email', 'mobile')->where('id', Auth::user()->id)->first();
        
        $msg = 'Your Star Auto Power #ord'. $order_code .' has been placed and will be delivered on your preferred delivery time: '. $delivery->day_slot .',  Helpline: 01911861426';

        $MSG = new SendSMS();

        //eail send
        $MSG->MailSend($user->email, $msg);

        //message send
        $msgResponse = $MSG->MessageSend($user->mobile, $msg);

        //Clear Cart items
        Cart::destroy();

        return redirect()->route('payment', ['orderId' => $order->id] )->with('success', 'Product order successfully added!.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function payment($id)
    {   
        $orderInfo = Order::where('id', $id)->where('user_id', Auth::user()->id)->first(); 

        if (! $orderInfo) {
            return redirect()->route('403');
        }
       
        //$orderInfo = Order::find($id);
        $deliveryInfo = Delivery::find($orderInfo->delivery_id);

        return view('checkout.payment', compact('orderInfo', 'deliveryInfo'));
    }


    //Cancel Order
    public function OrderCancel(Request $request)
    {
        $ordid = $request->order_id;

        $orderInfo = Order::where('id', $ordid)->where('user_id', Auth::user()->id)->first(); 

        if (! $orderInfo) {
            return redirect()->route('403');
        }

        $order = Order::findOrFail($ordid);
        $order->status = 3;
        $order->save();

        $idcancled = $request->prefix.$ordid;

        $msg = 'Your Star Auto Power #ord'. $orderInfo->order_code   .' has been Cancled, for more information Helpline: 01911861426'; 

        $MSG = new SendSMS(); 
 
        //eail send
        $MSG->MailSend(Auth::user()->email, $msg);

        //message send
        $msgResponse = $MSG->MessageSend(Auth::user()->mobile, $msg);


        return redirect()->route('checkout.cancelitem', ['id'=>$idcancled] )->with('success', 'Your order has been cancelled successfully!.');
    }
    
    //return id by Title
    public function arId($title)
    {
        return Area::where('title', $title)->first()->id;
    }

    //return timelis by id
    public function arTime($id)
    {
        return Area::where('id', $id)->first()->time_list;
    }


    //Send Time list json data
    public function GetTimelist(Request $request, $delId, $dayval)
    {  

       $deliveryInfo = Delivery::where('id', $delId )->where('status', 1)->first();

        $arid = $this->arId($deliveryInfo->area) !== null ? $this->arId($deliveryInfo->area): '2';

        $artime = json_decode($this->arTime($arid));

        if ($artime) {
            $timelist = Timelist::whereIn('id', $artime)->get();
            foreach ($timelist as $tmlist) {
                 $time[$tmlist->time_key] = $tmlist->time_val;
            } 
        }

        $curh = date('H') == '00'? 24 : date('H');

        $i=0;
        foreach ($time as $tky => $tval) {
            if(date("l, d M") == $dayval && $curh < max(array_keys($time))){
                if ($curh < $tky) {
                    $ReturnTime["v$i"]["val"] =  $tval;
                }                
            }else {
              $ReturnTime["v$i"]["val"] =  $tval;
            }
        $i++;
        }
       return json_encode($ReturnTime);
    } 


    //Add New Delevery Address
    public function AddDelivery(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
            'area' => 'required'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()]);
        }

        //Save Delivery information
        $delivery = new Delivery();
        $delivery->user_id   = Auth::user()->id;        
        $delivery->name      = $request->input('name');
        $delivery->address   = $request->input('address');
        $delivery->mobile    = $request->input('mobile');
        $delivery->area_id   = $request->input('area');
        $delivery->area      = Area::where('id', $request->input('area'))->first()->title??'';    
        $delivery->status       = 1;
        $delivery->save();

        //return delivery info
        $deliveryInfo['id']         = $delivery->id;
        $deliveryInfo['name']       = $delivery->name;
        $deliveryInfo['address']    = $delivery->address;
        $deliveryInfo['mobile']     = $delivery->mobile;
        $deliveryInfo['area']       = $delivery->area;
        $deliveryInfo['area_id']    = $delivery->area_id;

        //return Time Slot Info
        $arid = $this->arId($delivery->area) !== null ? $this->arId($delivery->area): '';

        $artime = json_decode($this->arTime($arid));

        if ($artime) {
            $timelist = Timelist::whereIn('id', $artime)->get();
            foreach ($timelist as $tmlist) {
                 $time[$tmlist->time_key] = $tmlist->time_val;
            } 
        }

        $curh = date('H') == '00'? 24 : date('H');

        if($curh < max(array_keys($time))){
            $dayslot[0]['key'] = date("l, d M");
            $dayslot[0]['val'] = 'Today,'. date("d M"); 
        }

        $dayslot[1]['key'] = date("l, d M", time()+86400);
        $dayslot[1]['val'] = 'Tomorrow,'.date("d M", time()+86400);

        $dayslot[2]['key'] = date("l, M d", time()+172800);
        $dayslot[2]['val'] = date("l, M d", time()+172800);

        $dayslot[3]['key'] = date("l, M d", time()+259200);
        $dayslot[3]['val'] = date("l, M d", time()+259200);

        
        $i =0;
        foreach ($time as $tky => $tval) {
            if( $curh < max(array_keys($time))){
                if ($curh < $tky) {
                    $ReturnTime["v$i"]["val"] =  $tval;
                }                
            }else {
              $ReturnTime["v$i"]["val"] =  $tval;
            }
        $i++;
        }

        //return Delivery Charge
        $charge = Area::where('id', $arid)->first()->delivery_charge;

        return json_encode(array('delivery' => $deliveryInfo, 'timeslot' => $ReturnTime, 'charge'=> $charge, 'dayslot'=>$dayslot, 'status' => '200'));
    }


    //Add New Delevery Address
    public function EditDelivery(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
            'area' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $delivery = Delivery::findOrFail($id);
        
        $delivery->user_id      = Auth::user()->id;        
        $delivery->name         = $request->input('name');
        $delivery->address      = $request->input('address');
        $delivery->mobile       = $request->input('mobile');
        $delivery->area_id      = $request->input('area');
        $delivery->area         = Area::where('id', $request->input('area'))->first()->title??'';       
        $delivery->status       = 1;
        $delivery->save();

        //return delivery info
        $deliveryInfo['id']         = $delivery->id;
        $deliveryInfo['name']       = $delivery->name;
        $deliveryInfo['address']    = $delivery->address;
        $deliveryInfo['mobile']     = $delivery->mobile; 
        $deliveryInfo['area']       = $delivery->area;
        $deliveryInfo['area_id']    = $delivery->area_id;


        //return Time Slot Info
        $arid = $this->arId($delivery->area) !== null ? $this->arId($delivery->area): '';

        $artime = json_decode($this->arTime($arid));

        if ($artime) {
            $timelist = Timelist::whereIn('id', $artime)->get();
            foreach ($timelist as $tmlist) {
                 $time[$tmlist->time_key] = $tmlist->time_val;
            } 
        }

        $curh = date('H') == '00'? 24 : date('H');

        if($curh < max(array_keys($time))){
            $dayslot[0]['key'] = date("l, d M");
            $dayslot[0]['val'] = 'Today,'. date("d M"); 
        }

        $dayslot[1]['key'] = date("l, d M", time()+86400);
        $dayslot[1]['val'] = 'Tomorrow,'.date("d M", time()+86400);

        $dayslot[2]['key'] = date("l, M d", time()+172800);
        $dayslot[2]['val'] = date("l, M d", time()+172800);

        $dayslot[3]['key'] = date("l, M d", time()+259200);
        $dayslot[3]['val'] = date("l, M d", time()+259200);

        
        $i =0;
        foreach ($time as $tky => $tval) {
            if( $curh < max(array_keys($time))){
                if ($curh < $tky) {
                    $ReturnTime["v$i"]["val"] =  $tval;
                }                
            }else {
              $ReturnTime["v$i"]["val"] =  $tval;
            }
        $i++;
        }

        //return Delivery Charge
        $charge = Area::where('id', $arid)->first()->delivery_charge;

        return json_encode(array('delivery' => $deliveryInfo, 'timeslot' => $ReturnTime, 'charge'=> $charge, 'dayslot'=>$dayslot));
    }
    public function cancelItem($id)
    {
        return view('checkout.cancelOrder', compact('id'));
    }
}
