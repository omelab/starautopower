<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests; // request method
use Illuminate\Support\Facades\Auth;
use App\Slider;
use App\Product;
use App\Category; //Cagetory model load
use App\City; //City model load
use App\Area; //Area model load
use File;
use Session;
use DB;
use App\SendSMS;


class FrontController extends Controller
{	
	// Home page products
    public function index()
    {   
        $key = request()->ps;

        $products = Product::where('is_home', '=',  1)->where('status', 1)->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->take(6)->get();

        $services = Product::where('is_home', '=',  1)->where('status', 1)->whereHas('categories', function ($query){  $query->where('slug', 'services'); })->take(8)->get();;
        
        if ($key) {
            $products = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->latest()->paginate(20);
            $services = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->whereHas('categories', function ($query){  $query->where('slug', 'services'); }) ->latest()->paginate(20);
        }
        

        if(Session::has('s_city')):
            $products = Product::where('status', 1)->where('is_home', '=',  1)->whereHas('cities', function($q) {
                $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
            })->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->latest()->paginate(20);

            $services = Product::where('is_home', '=',  1)->where('status', 1)->whereHas('categories', function ($query){  $query->where('slug', 'services'); })->whereHas('cities', function($q) {  $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
            })->latest()->paginate(20);

            if ($key) {
                $products = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                })->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->latest()->paginate(20);

                $services = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->whereHas('categories', function ($query){  $query->where('slug', 'services'); })
                ->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                })
                ->latest()->paginate(20);
            }
        endif;

        $sliders = Slider::get();
 
 
        return view('home', compact('products','sliders', 'services'))->with('i', (request()->input('page', 1) - 1) * 20);
    }



    //Products page
    public function products($slug=null){	
        if($slug){
            $data['category'] = Category::where('slug', $slug)->first();

             $data['products'] = Product::where('status', 1)->whereHas('categories', function ($query) use ($slug) {
              $query->where('slug', $slug);
            })->get();//latest()->paginate(20);

        }else{
             $data['products'] = Product::where('status', 1)->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->get();
        }
 
        
        if(Session::has('s_city')):
             if($slug){
                   $data['products'] = Product::where('status', 1)->whereHas('categories', function ($query) use ($slug){
                    $query->where('slug', $slug);
                  })->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                  })->get();//->latest()->paginate(20);
              }else{
                 $data['products'] = Product::where('status', 1)->whereDoesntHave('categories', function ($query){  $query->where('slug', 'services'); })->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                })->get();
          }
        endif;

        return view('products',  $data)->with('i', (request()->input('page', 1) - 1) * 20);
    }

    //Products page
    public function services($slug=null){ 

        $category = Category::where('slug', 'services')->first();

        $products = Product::where('status', 1)->whereHas('categories', function ($query){  $query->where('slug', 'services'); })->get();
         
        
        if(Session::has('s_city')):
            $products = Product::where('status', 1)->whereHas('categories', function ($query){  $query->where('slug', 'services'); })->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                })->get(); 
        endif;

        return view('products', compact('products', 'category'))->with('i', (request()->input('page', 1) - 1) * 20);
    }



    //Products Single Page
    public function singleProduct($id)
    {   
        $product = Product::where('status', 1)->find($id);

        $cat = $product->categories;
        
        $related = '';

        if($cat[0]->slug){
            $slug = $cat[0]->slug;
            $related = Product::where('status', 1)->whereHas('categories', function ($query) use ($slug) { $query->where('slug', $slug); })->limit(8)->get();//latest()->paginate(20);
        }

        return view('single-product',compact('product', 'related'));
    }

    //Search Page
    public function search(Request $request)
    {
        $key = request()->ps;

        if ($key =='') {
           return redirect()->route('404');
        }
        
        
        $products = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->latest()->paginate(20);

        if(Session::has('s_city')):
            $products = Product::where('status', 1)->where('title', 'like', '%'.$key.'%')->whereHas('cities', function($q) {
                    $q->where('title', Session::get('s_city')->title)->orwhere('title', 'All');
                })->latest()->paginate(20);            
        endif;

        return view('serach', compact('products', 'key'))->with('i', (request()->input('page', 1) - 1) * 20);
    }




    //get Area for ajax request
    public function get_Areabycity(Request $request, $id)
    {       
        $areas = Area::select('id','title')->where('city_id', $id)->orderBy('title', 'ASC')->get();
        return $areas;        
    }

    //Set Location popup request
    public function setlocation(Request $request)
    {   
        $areaInfo = Area::select('id', 'title')->where('id', $request->area_id)->first();
        $cityInfo = City::select('id', 'title')->where('id', $request->city_id)->first();
        $request->session()->put('s_city', $cityInfo);
        $request->session()->put('s_area', $areaInfo); 
        return Redirect::back();
    }
    
    //get Oeder Tracking
    public function OrderTracking(Request $request)
    {
        $order = str_replace("#","",$request->order);
        $order = str_replace("ord","",$order);

        $orderStatus = DB::table('orders')->where('order_code', $order)->first();

        if(isset($orderStatus->status)){
            return response()->json([
                'status' => $orderStatus->status, 
            ]);
        }

        return response()->json([
            'status' => 'error', 
        ]);

    }


    // About Page
    public function about()
    {   
        return view('pages.about');
    }

    // shipping Page
    public function shipping()
    {   
        return view('pages.shipping');
    }

    // privacy Page
    public function privacy()
    {   
        return view('pages.privacy');
    }

    // refund Page
    public function refund()
    {   
        return view('pages.refund');
    }

    // faq Page
    public function faq()
    {   
        return view('pages.faq');
    }

    // newses Page
    public function newses()
    {   
        return view('pages.newses');
    }

    // careers Page
    public function careers()
    {   
        return view('pages.careers');
    }

    // jobs Page
    public function jobs()
    {   
        return view('pages.jobs');
    }

    // terms Page
    public function terms()
    {   
        return view('pages.terms');
    }

    // terms Page
    public function contact()
    {   
        return view('pages.contact');
    }
    // terms Page
    public function showroom()
    {   
        return view('pages.showroom');
    }
    
}
