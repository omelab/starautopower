<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use App\Category; //for model load
use File;
use RomansHelper; 

class CategoryController extends Controller
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
        $categories = Category::where('parent_id', '=', 0)->orderByRaw('-position DESC')->get();       
        return view('admin.category.list')->with('cats', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cats = Category::where('parent_id', '=', 0)->get(); //pluck('title','id')->all();
        $allCategories = RomansHelper::Nested($cats);

        return view('admin.category.add', compact('allCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:800',
        'status' => 'required',
      ]);

      $input = $request->except('_token');

      if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);
        $input['image']=$imageName;
      }

      $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
      Category::create($input);
      return back()->with('success', 'New Category added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        // get the nerd
        $category = Category::find($id);
        $cats = Category::where('parent_id', '=', 0)->where('id', '!=', $id)->get(); //$allCategories = Category::where('id', '!=', $id)->get()->pluck('title','id');
        $allCategories = RomansHelper::Nested($cats);        
        return view('admin.category.edit',compact('category','allCategories'));
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
        $category = Category::findOrFail($id);

        $this->validate($request,[
            'title'   => 'required',
            'image'   => 'image|mimes:jpeg,png,jpg|max:800',
            'status'  => 'required',
        ]);

        $category->title     = $request->input('title');
        $category->slug      = null;
        $category->status    = $request->input('status');
        $category->position  = $request->input('position');        
        $category->parent_id = empty($request->input('parent_id')) ? 0 : $request->input('parent_id');
        
        if (!empty($request->image)) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $category->image =$imageName;

            File::delete(public_path('images/').$request->oldfile);
        }

        $category->save();      
        
        return redirect()->route('admin.category')
            ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $deleteItem = Category::where('id', '=', $id)->first();
        $oldImg = $deleteItem->image;
        if (!empty($oldImg)) {
          File::delete(public_path('images/'.$oldImg));
        }
        
        if(count($deleteItem->childs)){
            $input=['parent_id'=>$deleteItem->parent_id];
            Category::where('parent_id', $id)->update($input);
        }

        Category::where('id', $id)->delete();//delete row
        return redirect()->route('admin.category')
            ->with('success','category deleted successfully');
    }
}
