<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; // request method
use App\City; //for City model load
use App\Area; //for Area model load
use App\Timelist; //for Time List model load
class AreaController extends Controller
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
        $areas = Area::where('status', 1)->orderBy('title')->get();
        return view('admin.area.list')->with('areas', $areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::pluck('title','id')->all();
        $time = Timelist::pluck('time_val','id')->all();
        return view('admin.area.add', compact('cities', 'time'));
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
            'title'             => 'required',
            'city_id'           => 'required|integer',
            'status'            => 'required',
            'delivery_charge'   => 'required|numeric',
            'time_list'         => 'required',
        ]);

        $input['title']             = $request->title;
        $input['city_id']           = $request->city_id;
        $input['status']            = $request->status;
        $input['delivery_charge']   = $request->delivery_charge;
        $input['time_list']         = json_encode($request->time_list);

        Area::create($input);
        return back()->with('success', 'New Area added successfully.');
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
        $area = Area::find($id);
        $cities = $citites = City::pluck('title','id')->all();
        $time = Timelist::pluck('time_val','id')->all();
          return view('admin.area.edit',compact('area','cities', 'time'));
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
        
        $this->validate($request, [
            'title'             => 'required',
            'city_id'           => 'required|integer',
            'status'            => 'required',
            'delivery_charge'   => 'required|numeric',
            'time_list'         => 'required',
        ]);

        
        $area = Area::findOrFail($id);

        $area->title            = $request->title;
        $area->city_id          = $request->city_id;
        $area->status           = $request->status;
        $area->delivery_charge  = $request->delivery_charge;
        $area->time_list        = json_encode($request->time_list);

        $area->save();        
        return redirect()->route('admin.area')
            ->with('success','Area updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Area::where('id', $id)->delete();//delete row
        return redirect()->route('admin.area')
            ->with('success','Area deleted successfully');
    }
    
}
