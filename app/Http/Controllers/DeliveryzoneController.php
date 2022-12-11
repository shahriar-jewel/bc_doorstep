<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BranchDeliveryzoneMap;
use App\Models\Deliveryzone;
use DB;

class DeliveryzoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $_profileID = 0 ;

    private function _setProfileInfo()
    {
        $this->_profileID = session()->get('doorstepuser.userid');
    }

    public function index()
    {
       
        $deliveryzone = DB::select("SELECT zoneid,zonename,is_active FROM deliveryzone");

        return view('deliveryzone.index',compact('deliveryzone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurantID = session()->get('doorstepuser.restaurantid') ;
        $allKitchen=getKitchensbyRestaurant($restaurantID);
        return view('deliveryzone.create',compact('allKitchen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_setProfileInfo();
        
        $rules = array(
            'zonename'             => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            return  redirect()->back()->withErrors($validator);
        }
        else{

            $deliveryzonedata = new Deliveryzone();
            $deliveryzonedata->zonename = $request->get('zonename'); 
            $deliveryzonedata->is_active = $request->get('is_active'); 
            $deliveryzonedata->created_by = $this->_profileID;
            $deliveryzonedata->save();  
          $message = "Delivery Zone added successfully !";
          session()->flash('message', $message );
          session()->flash('class', '1');
          return redirect()->route('deliveryzone.index');
      }
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
        $zonename = DB::select("SELECT zoneid,zonename,is_active from deliveryzone where zoneid = '".$id."'");
        return json_encode($zonename);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function zoneupdate(Request $req)
    {
        Deliveryzone::where('zoneid',$req->zoneid)->update(array(
            'zonename' => $req->zonename,
            'is_active' => $req->is_active
        ));
        $message = "Delivery Zone updated successfully !";
        session()->flash('message', $message );
        session()->flash('class', '1');
        return redirect()->route('deliveryzone.index');
    }
}
