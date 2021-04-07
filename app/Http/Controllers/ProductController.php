<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use App\Product;
use App\Category; //Cagetory model load
use App\City; //City model load
use App\Area; //Area model load
use App\ProductImage; // Product Image upload
use App\Option; // Product Options
use File;
use Session;
use RomansHelper; 

class ProductController extends Controller
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
    public function index()
    {  
        /*Product::latest()
            ->leftJoin('categories', 'products.cat_id', '=', 'categories.id')
            ->leftJoin('cities', 'products.city_id', '=', 'cities.id')
            ->select('products.*', 'categories.title as catTitle','cities.title as cityTitle' )
            ->paginate(5);*/

        $products = Product::with('categories')->with('cities')->orderBy('id', 'DESC')->get();// ->latest()->paginate(20);
        return view('admin.products.list', compact('products'));//->with('i', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $cats = Category::where('parent_id', '=', 0)->get(); //pluck('title','id')->all();
        $allCategories = RomansHelper::Nested($cats);
        $allCities = City::pluck('title','id')->all();
        return view('admin.products.add', compact('allCategories','allCities'));
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
            'title'         => 'required',
            'sku'           => 'required',
            'regular_price' => 'required|numeric',
            'sale_price'    => 'required|numeric', 
            'cat_id'        => 'required',
            'city_id'       => 'required',
            'status'        => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:1000',
            'photo'         => 'array',
            'photo.*'       => 'image|mimes:jpeg,bmp,png|size:2000',
        ]);

        $product = new Product();

        $product->title         = $request->input('title');
        $product->sku           = $request->input('sku');
        $product->stock_qty     = $request->input('stock_qty');        
        $product->regular_price = $request->input('regular_price');
        $product->sale_price    = $request->input('sale_price');
        $product->status        = $request->input('status');
        $product->detail        = $request->input('detail');
        $product->is_home       = empty($request->input('is_home')) ? 0 : $request->input('is_home');
        

        if($request->hasFile('image')) {
            $imageName = time().'-'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $success = $product->save();
        $product->categories()->sync($request->cat_id, false);
        $product->cities()->sync($request->city_id, false);

        if($request->hasFile('photos')){
            $g=1;
            foreach($request->file('photos') as $file){                
                //$name = time().$g.'_gl.'.$file->getClientOriginalExtension();
                $name = time().$g.'gl-'.$file->getClientOriginalName();
                $file->move(public_path('images'), $name);

                ProductImage::create([
                        'product_id' => $product->id,
                        'filename' => $name,
                    ]
                );
                $g++;               
            }
        }

        if ($success) {
            return redirect()->route('admin.edit-products', $product->id)->with('success', 'New Product added successfully.');
        }else{
            return Redirect::back()->withErrors(['error', 'Something Wrong! please provide correct information']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   

        $cats = Category::where('parent_id', '=', 0)->get(); //pluck('title','id')->all();
        $allCategories = RomansHelper::Nested($cats);

        $allCities = City::pluck('title','id')->all();
        
        $product = Product::find($id);
                        
        return view('admin.products.show',compact('allCities','allCategories','product'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $cats = Category::where('parent_id', '=', 0)->get(); //pluck('title','id')->all();
        $allCategories = RomansHelper::Nested($cats);

        $allCities = City::pluck('title','id')->all();

        $product = Product::find($id);

        $pimages = ProductImage::where('product_id', '=', $product->id)->get();

        return view('admin.products.edit',compact('allCities','allCategories','product', 'pimages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request,[
            'title'         => 'required',
            'sku'           => 'required',
            'regular_price' => 'required|numeric',
            'sale_price'    => 'required|numeric',
            'cat_id'        => 'required',
            'city_id'       => 'required',
            'status'        => 'required',
            'detail'        => 'required',
            'image'         => 'image|mimes:jpeg,png,jpg|max:1000',
            'photo'         => 'array',
            'photo.*'       => 'image|mimes:jpeg,bmp,png|size:2000',
        ]);

        $product->title         = $request->input('title');
        $product->sku           = $request->input('sku');
        $product->regular_price = $request->input('regular_price');
        $product->sale_price    = $request->input('sale_price');
        $product->stock_qty     = $request->input('stock_qty'); 
        $product->status        = $request->input('status');
        $product->detail        = $request->input('detail');
        $product->is_home       = empty($request->input('is_home')) ? 0 : $request->input('is_home');

        if($request->hasFile('image')) {
            //$imageName = time().'.'.$request->image->getClientOriginalExtension();
            $imageName = time().'-'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;

            //deleting old image
            $oldfile = public_path('images/').$request->oldfile;
            if (File::exists($oldfile)) {
                File::delete($oldfile);
            }
        }

        $success = $product->save();
        $product->categories()->sync($request->cat_id);
        $product->cities()->sync($request->city_id);

        if($request->hasFile('photos')){
            $g=1;
            foreach($request->file('photos') as $file){
                $name = time().$g.'gl-'.$file->getClientOriginalName();
                $file->move(public_path('images'), $name);

                ProductImage::create([
                        'product_id' => $product->id,
                        'filename' => $name,
                    ]
                ); 
                $g++;              
            }
        }

        if ($success) {
            Session::flash('flash_message', 'Service successfully added!');
            return redirect()->route('admin.products')->with('success', 'Product Item Updated successfully.');
        }else{
            return Redirect::back()->withErrors(['error', 'Something Wrong! please provide correct information']);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $deleteItem = Product::where('id', '=', $id)->first();
        $oldImg = $deleteItem->image;

        $oldfile = public_path('images/').$deleteItem->image;

        if (File::exists($oldfile)) {
            File::delete($oldfile);
        }
        
        $product = Product::findOrFail($id);
        $product->categories()->detach();
        $product->cities()->detach();
        
        ProductImage::where('product_id', $id)->delete();

        $product->delete();

        //Product::where('id', $id)->delete();//delete row        

        return redirect()->route('admin.products')
            ->with('success','Product Item deleted successfully');
    }

    //get Area for ajax request
    public function getAreas(Request $request, $id)
    {       
        $areas = Area::select('id','title')->where('city_id', $id)->get();
        return $areas;        
    }

    //get Area for ajax request
    public function getProductsByCategory(Request $request)
    {
        $category = Category::whereName($request->category)->firstOrFail();
        $products = Product::where('category',$category->id)->get();
        return response()->json(['products'=>$products]); 
    }

    //Gallery Image Delete by ajax request
    public function imgdestroy(Request $request)
    {
        $id = $request->input('imgid');

        $delimg = ProductImage::where('id', '=', $id)->first();
        $delfile = public_path('images/').$delimg->filename;
        $prid =  $delimg->product_id;

        if (File::exists($delfile)) {
            File::delete($delfile);
        }
        
        $primg = ProductImage::findOrFail($id);
        $primg->delete();

        $restimg = ProductImage::select('id','filename')->where('product_id', $prid)->get();
        return response()->json(['images'=>$restimg]); 
    }


    //Store Products Options by ajax request
    public function storOptins(Request $request){

        $request->validate([
            'product_id'        => 'required',
            'size'              => 'required_without:color',
            'color'             => 'required_without:size', 
            'regular_price'     => 'required|numeric',
            'sales_price'       => 'required|numeric',
            'quantity'          => 'required|numeric',
            'images'            => 'image|mimes:jpeg,png,jpg|max:1000',
        ]);
        $newName = '';
        if($request->hasFile('images')) {
            $newName = time().'-opt-'.$request->images->getClientOriginalName();
            $request->images->move(public_path('images'), $newName);
        }

        Option::create([
            'product_id'       => $request->input('product_id'),
            'size'             => $request->input('size'),
            'color'            => $request->input('color'),
            'regular_price'    => $request->input('regular_price'),
            'sales_price'      => $request->input('sales_price'),
            'quantity'         => $request->input('quantity'),
            'images'           => $newName,
        ]);

        $options = Option::where('product_id', '=', $request->input('product_id'))->get();

        return response()->json(['options'=>$options]); 
    }


    public function optionDestroy(Request $request) {

        $request->validate([
            'optid'  => 'required',
        ]);


        $delopt = Option::where('id', '=', $request->input('optid'))->first();        
        $delfile = public_path('images/').$delopt->images;
        $prid =  $delopt->product_id;

        if (File::exists($delfile)) {
            File::delete($delfile);
        }
        
        $option = Option::findOrFail($request->input('optid'));
        $option->delete();

        $options = Option::where('product_id', '=', $prid)->get();

        return response()->json(['options'=>$options]);
    }
}
