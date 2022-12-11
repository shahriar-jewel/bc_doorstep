<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RestaurantRequest;

use App\Models\Restaurant;
use App\Models\RestaurantTypeMap;

class RestaurantController extends Controller
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
        // $allrestaurant = Restaurant::with('branches')->get()->toArray();
        // dd($allrestaurant);


        // $allrestaurant = Restaurant::paginate(15);
        $allrestaurant = Restaurant::all();
        return view('restaurant.index',compact('allrestaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantRequest $request)
    {
        $this->_setProfileInfo();

        $data = array(
                    'name'          => $request->input('name'),
                    'contactno'     => $request->input('contactno'),
                    'email'         => $request->input('email'),
                    'address'       => $request->input('address'),
                    'otherdetail'   => $request->input('otherdetail'),
                    'is_active'     => $request->input('is_active'),
                    'websiteurl'    => $request->input('websiteurl'),
                    'created_by'    => $this->_profileID
                );

        $restaurantData = Restaurant::firstOrCreate($data);

        $types = $request->input('restauranttype') ;
        $typeData = array();

        foreach ($types as $typeID) 
        {
            $typeData[] = array(
                'restaurantid'  => $restaurantData->restaurantid,
                'typeid'        => $typeID,
                'created_by'    => $this->_profileID
            );
        }

        RestaurantTypeMap::insert($typeData);

        session()->flash('message', 'New Restaurant Created Successfully !');
        session()->flash('class', '1');
        return redirect()->route('restaurant.index');

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
        $restaurant = Restaurant::find($id);

        if (count($restaurant) > 0 ) 
        {
            $typeIDs = array();
            foreach( $restaurant['restaurantTypes'] as $type )
                if(isset( $type['typeInfo'] ))
                    $typeIDs[]=$type['typeInfo']['typeid'];

            return view('restaurant.edit',compact('restaurant','typeIDs'));
        }
        else
        {
            session()->flash('message', 'Could not find the restaurant !');
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
    public function update(RestaurantRequest $request)
    {
        $this->_setProfileInfo();
        $restaurantid = $request->input('resid');
        $data = array(
                    'name'          => $request->input('name'),
                    'contactno'     => $request->input('contactno'),
                    'email'         => $request->input('email'),
                    'address'       => $request->input('address'),
                    'otherdetail'   => $request->input('otherdetail'),
                    'is_active'     => $request->input('is_active'),
                    'websiteurl'    => $request->input('websiteurl'),
                    'updated_by'    => $this->_profileID
                );

        $updateInfo = Restaurant::where('restaurantid',$restaurantid)->update($data);
        if ($updateInfo > 0) {

            RestaurantTypeMap::where('restaurantid',$restaurantid)->delete();

            $types = $request->input('restauranttype') ;
            $typeData = array();
            foreach ($types as $typeID) 
            {
                $typeData[] = array(
                    'restaurantid'  => $restaurantid,
                    'typeid'        => $typeID,
                    'created_by'    => $this->_profileID
                );
            }

            RestaurantTypeMap::insert($typeData);

            $message = "Restaurant Updated Successfully !" ;
            $class = 1;
        }else{
            $message = "No restaurant found ! Something went wrong !" ;
            $class = 2;
        }
        session()->flash('message', $message );
        session()->flash('class', $class );
        return redirect()->route('restaurant.index');
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
