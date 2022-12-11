<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests\BranchRequest;

use App\Models\Kitchen;
use App\Models\Kitchenopenclosetime;
use App\Models\BranchDeliveryzoneMap;


class KitchenController extends Controller
{
    private $_profileID = 0 ;

    private function _setProfileInfo()
    {
        $this->_profileID = session()->get('doorstepuser.userid');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $allbranch = Branch::paginate(15);
        $allkitchen = Kitchen::get();
        // dd($allbranch[2]->branchopentime);
        return view('kitchen.index',compact('allkitchen'));
    }

    public function create()
    {
        return view('kitchen.create');
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

        $sattime = $request->input('satstarttime').' - '.$request->input('satendtime');
        $suntime = $request->input('sunstarttime').' - '.$request->input('sunendtime');
        $montime = $request->input('monstarttime').' - '.$request->input('monendtime');
        $tuetime = $request->input('tuestarttime').' - '.$request->input('tueendtime');
        $wedtime = $request->input('wedstarttime').' - '.$request->input('wedendtime');
        $thutime = $request->input('thustarttime').' - '.$request->input('thuendtime');
        $fritime = $request->input('fristarttime').' - '.$request->input('friendtime');
        // $sattime = $request->input('satendtime');

        // dd($sattime);
        $data = array(
                    'restaurantid'      => $request->input('restaurant'),
                    'kitchenname'        => $request->input('kitchenname'),
                    'contactno'         => $request->input('contactno'),
                    'email'             => $request->input('email'),
                    'address'           => $request->input('address'),
                    'latitude'          => $request->input('lat'),
                    'longitude'         => $request->input('lng'),
                    'minorderamount'    => $request->input('minorderamount'),
                    'otherdetail'       => $request->input('otherdetail'),
                    'is_active'         => $request->input('is_active'),
                    'created_by'        => $this->_profileID
                );


        $kitchendata = Kitchen::firstOrCreate($data);

        $data_openstarttime = array(
                    'kitchenid'         => $kitchendata->kitchenid,
                    'saturday'          => $sattime,
                    'saturday_status'   => $request->input('satcheck') ? $request->input('satcheck') : 0 ,
                    'sunday'            => $suntime,
                    'sunday_status'     => $request->input('suncheck') ? $request->input('suncheck') : 0 ,
                    'monday'            => $montime,
                    'monday_status'     => $request->input('moncheck') ? $request->input('moncheck') : 0 ,
                    'tuesday'           => $tuetime,
                    'tuesday_status'    => $request->input('tuecheck') ? $request->input('tuecheck') : 0 ,
                    'wednesday'         => $wedtime,
                    'wednesday_status'  => $request->input('wedcheck') ? $request->input('wedcheck') : 0 ,
                    'thursday'          => $thutime,
                    'thursday_status'   => $request->input('thucheck') ? $request->input('thucheck') : 0 ,
                    'friday'            => $fritime,
                    'friday_status'     => $request->input('fricheck') ? $request->input('fricheck') : 0 ,
                    'created_by'        => $this->_profileID
                );
        $kitchendata = Kitchenopenclosetime::firstOrCreate($data_openstarttime);

        session()->flash('message', 'New Kitchen Created Successfully !');
        session()->flash('class', '1');
        return redirect()->route('kitchen.index');
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
        $kitchen = Kitchen::find($id);

        if (count($kitchen) > 0 ) 
        {
            return view('kitchen.edit',compact('kitchen'));
        }
        else
        {
            session()->flash('message', 'Could not find the kitchen !');
            session()->flash('class', '2');
            return redirect()->back();
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
        $this->_setProfileInfo();
        $kitchenid = $request->input('kitchenid');
        $data = array(
                    'restaurantid'      => $request->input('restaurant'),
                    'kitchenname'        => $request->input('kitchenname'),
                    'contactno'         => $request->input('contactno'),
                    'email'             => $request->input('email'),
                    'address'           => $request->input('address'),
                    'latitude'          => $request->input('lat'),
                    'longitude'         => $request->input('lng'),
                    'minorderamount'    => $request->input('minorderamount'),
                    'mindeliverytime'   => $request->input('mindeliverytime'),
                    'otherdetail'       => $request->input('otherdetail'),
                    'is_active'         => $request->input('is_active'),
                    'updated_by'        => $this->_profileID
                );

        $updateInfo = Kitchen::where('kitchenid',$kitchenid)->update($data);

        $sattime = $request->input('satstarttime').' - '.$request->input('satendtime');
        $suntime = $request->input('sunstarttime').' - '.$request->input('sunendtime');
        $montime = $request->input('monstarttime').' - '.$request->input('monendtime');
        $tuetime = $request->input('tuestarttime').' - '.$request->input('tueendtime');
        $wedtime = $request->input('wedstarttime').' - '.$request->input('wedendtime');
        $thutime = $request->input('thustarttime').' - '.$request->input('thuendtime');
        $fritime = $request->input('fristarttime').' - '.$request->input('friendtime');

        $data_openstarttime = array(
                    'saturday'          => $sattime,
                    'saturday_status'   => $request->input('satcheck') ? $request->input('satcheck') : 0 ,
                    'sunday'            => $suntime,
                    'sunday_status'     => $request->input('suncheck') ? $request->input('suncheck') : 0 ,
                    'monday'            => $montime,
                    'monday_status'     => $request->input('moncheck') ? $request->input('moncheck') : 0 ,
                    'tuesday'           => $tuetime,
                    'tuesday_status'    => $request->input('tuecheck') ? $request->input('tuecheck') : 0 ,
                    'wednesday'         => $wedtime,
                    'wednesday_status'  => $request->input('wedcheck') ? $request->input('wedcheck') : 0 ,
                    'thursday'          => $thutime,
                    'thursday_status'   => $request->input('thucheck') ? $request->input('thucheck') : 0 ,
                    'friday'            => $fritime,
                    'friday_status'     => $request->input('fricheck') ? $request->input('fricheck') : 0 ,
                    'updated_by'        => $this->_profileID
                );
        // $branchdata = Branchopenclosetime::where('branchid',$branchid)->updateOrCreate( [ 'branchid' => $branchid ],$data_openstarttime);
        $kitchendata = Kitchenopenclosetime::updateOrCreate( [ 'kitchenid' => $kitchenid ],$data_openstarttime);

        
        if ($updateInfo > 0) {
            $message = "Kitchen Updated Successfully !" ;
            $class = 1;
        }else{
            $message = "No kitchen found ! Something went wrong !" ;
            $class = 2;
        }
        session()->flash('message', $message );
        session()->flash('class', $class );
        return redirect()->route('kitchen.index');
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
}
