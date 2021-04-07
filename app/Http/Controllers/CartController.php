<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use Cart;
Use Redirect;
use App\Product;
use App\Option;
use RomansHelper;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Cart::count()<1) {
            return redirect()->route('home')
            ->with('error','You have not cart item now');
        }

        $cartItems = Cart::content();
        return view('cart.index', ['cartItems'=> $cartItems]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function addcart(Request $request)
    {   
        $this->validate($request,[
            'pid' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);

        //get product data by product id
        $product = Product::find($request->pid);
        $prOptions = $product->options;

        if ( count($prOptions)>0 ) {

            $checkSize = FALSE;
            $checkColor = FALSE;
            $cartopt = array();

            foreach ($prOptions as $opt) {
                if ($opt->size !='' && $opt->quantity > 0) {
                    $checkSize = TRUE;
                }
                if ($opt->color !='' && $opt->quantity > 0) {
                    $checkColor = TRUE;
                }
            }

            if ($checkSize) {
                $this->validate($request, [
                    'size' => 'required|not_in:0',
                ]);

                $cartopt['size'] = $request->size;
            }

            if ($checkColor) {
                $this->validate($request, [
                    'color' => 'required|not_in:0',
                ]);

                $cartopt['color'] = $request->color;
            }

            $opQuery = Option::where('product_id', '=', $request->pid);

            if ($request->size && $request->size !='') {
                $opQuery = $opQuery->where('size', '=', $request->size);
            }

            if ($request->color && $request->color !='') {
                 $opQuery = $opQuery->where('color', '=', $request->color);
            }

            $prOptions = $opQuery->first();

            $chqty = 0;
            $items = Cart::content();

            foreach ($items as $item) {
               if($item->options->optid == $prOptions->id) {
                    $chqty = (int)($item->qty);
                    break; 
                }
            }

            $stocks = (int) $prOptions->quantity - $chqty;


            if ($stocks > 0 ) {
                $this->validate($request, [
                    'qty' => 'required|numeric|min:1|max:'.$stocks,
                ]);

                $cartopt['detail'] = $product->detail;
                $cartopt['image'] = $prOptions->images;
                $cartopt['regprice'] = $prOptions->regular_price;
                $cartopt['optid'] = $prOptions->id;

            }else{
                return Redirect::back()->with('error', 'Sorry! we think you have already added maximum quantity');
            }
            
       
            $result = Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $request->qty, 'price' => $prOptions->sales_price, 'options' => $cartopt]);

            if ($result) {

                return redirect('/cart');

                //return Redirect::back()->with('success', 'Cart Item added successfully.');
            }else{
                return Redirect::back()->with('error', 'Something Wrong! please provide correct information');
            }

        }else{


            $chqty = 0;

            $items = Cart::content();

            foreach ($items as $item) {
               if($item->id == $request->pid) {
                    $chqty = (int)($item->qty);
                    break; 
                }
            }

            $stocks = (int) $product->stock_qty - $chqty;

            $this->validate($request, [
                'qty' => 'required|numeric|min:1|max:'.$stocks,
            ]);

            $result = Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $request->qty, 'price' => $product->sale_price, 'options' => ['detail' => $product->detail, 'image' => $product->image, 'regprice' => $product->regular_price]]);

            if ($result) {

                return redirect('/cart');

                //return Redirect::back()->with('success', 'Cart Item added successfully.');
            }else{
                return Redirect::back()->withErrors(['error', 'Something Wrong! please provide correct information']);
            }
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'pid' => 'required',
        ]);

        //request product id
        $productId = $request->pid;
        $qty = $request->item;

        
        //get product data by product id
        $product = Product::find($productId);

        $chqty = $qty;

        $items = Cart::content();

        foreach ($items as $item) {
           if($item->id == $product->id) {
                $chqty = (int)($chqty + $item->qty);
                break; 
            }
        }

        if ($product->stock_qty >= $chqty ) {
            Cart::add(['id' => $product->id, 'name' => $product->title, 'qty' => $qty, 'price' => $product->sale_price, 'options' => ['detail' => $product->detail, 'image' => $product->image, 'regprice' => $product->regular_price]]);

            //return cart response
            return $this->jsoncart();
        }else{
            return response()->json(array(
                'success' => false,
                'error'   => 'Sorry! you can add this product maximum '. $chqty .' Quantity',
            ));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $this->validate($request, [
            'rowid' => 'required',
            'qty' => 'required',
        ]);
        
        $rowId  = $request->rowid;        
        $newQty = (int) $request->qty;

        $itemcart = Cart::get($rowId);

        if ( $itemcart->options->has('size') ||  $itemcart->options->has('color') ) {
        
            $opQuery = Option::where('product_id', '=', $itemcart->id);

            if ( $itemcart->options->has('size') ) {
                $opQuery = $opQuery->where('size', '=', $itemcart->options->size);
            }

            if ( $itemcart->options->has('color') ) {
                $opQuery = $opQuery->where('color', '=', $itemcart->options->color);
            }

            $prOptions = $opQuery->first();

            if ( $prOptions->quantity >= $newQty ) {

                Cart::update($rowId, $newQty); 

                return $this->jsoncart();

            }else{

                return response()->json(array(
                    'success' => false,
                    'error'   => 'Sorry! you can\'t add more item quantity',
                ));
            }

        }else{
            $product = Product::find($itemcart->id);

            if ( $product->stock_qty >= $newQty ) {

                Cart::update($rowId, $newQty); 

                return $this->jsoncart();

            }else{

                return response()->json(array(
                    'success' => false,
                    'error'   => 'Sorry! you can\'t add more item quantity',
                ));

            }

        }
       
        //return cart response
        return response()->json(array(
            'success' => false,
            'error'   => 'Something wrong!, please try later',
        ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $rowId  = $request->rowid;
        Cart::remove( $rowId );
        
        //return cart response
        return $this->jsoncart();
    }

    //cart remove using route
    public function cartDestroy($id)
    {   
        Cart::remove( $id );
        return redirect('/cart');
    }



    /**
     * Display a cart jeson data
     *
     * @return \Illuminate\Http\Response
     */
    public function jsoncart()
    {   
        //'options' => ['image' => $product->image, 'regprice' => $product->regular_price]
        $discount = RomansHelper::get_discountPrice(Cart::content(), Cart::total(0, false, false)); 
        return response()->json(array(
                'success' => true,
                'data'    => Cart::content(),
                'total'   => Cart::total(0, false, false),
                'discount'   => $discount,
                'count'   => Cart::content()->count(),
            ));
    }

}