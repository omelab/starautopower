<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use App\Slider;
use File;
use Session;

class SliderController extends Controller
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
        $sliders = Slider::get();
        return view('admin.slider.list', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.slider.add');
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
            'status'        => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:1000',
        ]);

        $slider = new Slider();

        $slider->title         = $request->input('title');
        $slider->status        = $request->input('status');        

        if($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $slider->image = $imageName;
        }

        $slider->save();

        Session::flash('flash_message', 'Slider successfully added!');
        return redirect()->route('admin.slider')->with('success', 'New Slider added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   

        $slider = Slider::find($id);
        return view('admin.slider.show',compact('slider'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $slider = Slider::find($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $this->validate($request,[
            'title'         => 'required',            
            'status'        => 'required',           
            'image'         => 'image|mimes:jpeg,png,jpg|max:1000',
        ]);

        $slider->title      = $request->input('title');
        $slider->status     = $request->input('status');

        if($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $slider->image = $imageName;

            //deleting old image
            $oldfile = public_path('images/').$request->oldfile;
            if (File::exists($oldfile))
            {
                File::delete($oldfile);
            }
        }

        $slider->save();
        Session::flash('flash_message', 'Slider successfully Updated!');
        return redirect()->route('admin.slider')->with('success', 'Slider Item Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $deleteItem = Slider::where('id', '=', $id)->first();
        $oldImg = $deleteItem->image;

        $oldfile = public_path('images/').$deleteItem->image;

        if (File::exists($oldfile))
        {
            File::delete($oldfile);
        }
        
        $slider = Slider::findOrFail($id);
        $slider->delete();    

        return redirect()->route('admin.slider')->with('success','Slider Item deleted successfully');
    }

}
