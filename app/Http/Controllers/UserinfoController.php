<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\UserinfostoreRequest;
use App\Http\Requests\UserinfoeditRequest;


use App\Models\Kitchen;
use App\Models\Userinfo;
use App\Models\UserKitchenMap;

class UserinfoController extends Controller
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
        // $alluserType = getUserType(); 
        // $alluserGender = getUserGender();
        // $restaurantID = session()->get('doorstepuser.restaurantid');
        // $_perPage = config('custom.pagination.items_per_page');
        // switch ($restaurantID) 
        // {
        //     case '-1':
        //         // $allUser = Userinfo::paginate($_perPage);
        //         $allUser = Userinfo::all();
        //         break;
        //     default:
        //         // $allUser = Userinfo::where('restaurantid',$restaurantID)->paginate($_perPage);
        //         $allUser = Userinfo::where('restaurantid',$restaurantID)->get();
        //         break;
        // }
        // return view('userinfo.index' , compact('allUser','alluserType','alluserGender') );
        return view('userinfo.index');
    }

    # AJAX for ALL User Info 
    public function getUserInfo(Request $request)
    {
        $allKitchen = getKitchensByUserType();
        $alluserType = getUserType(); 
        $alluserGender = getUserGender();

        $restaurantID = session()->get('doorstepuser.restaurantid');

        $columns = array(
                        0   => "slno" ,
                        1   => "name" ,
                        2   => "gender" ,
                        3   => "email" ,
                        4   => "contactno" ,
                        5   => "usertype" ,
                        6   => "status" ,
                        7   => "action" ,
                    );

        $DBcolumns = array(
                        0   => "userid" ,
                        1   => "fullname" ,
                        2   => "gender" ,
                        3   => "email" ,
                        4   => "contactno" ,
                        5   => "usertype" ,
                        6   => "isactive" ,
                        7   => "userid" ,
                    );

        switch ($restaurantID) 
        {
            case '-1':
                $totalData = Userinfo::count();
                break;
            default:
                $totalData = Userinfo::where('restaurantid',$restaurantID)->count();
                break;
        }
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $allUserInfo = Userinfo::leftjoin('restaurant', 'userinfo.restaurantid', '=', 'restaurant.restaurantid')
                                ->select('userinfo.*','restaurant.name' )
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir);
            switch ($restaurantID) 
            {
                case '-1':
                    $allUserInfo = $allUserInfo->get();
                    break;
                default:
                    $allUserInfo = $allUserInfo->where('userinfo.restaurantid',$restaurantID)->get();
                    break;
            }
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchByGender = 999 ;
            $searchByUsertype = 999;
            $searchByStatus = 999;

            foreach ($alluserType as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchByUsertype = $key; 
                    break;
                }
            }

            foreach ($alluserGender as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchByGender = $key; 
                    break;
                }
            }

            switch (strtolower($search)) 
            {
                case 'active':
                    $searchByStatus = 1; 
                    break;
                case 'inactive':
                    $searchByStatus = 0; 
                    break; 
                default:
                    $searchByStatus = 2; 
                    break;
            }

            $allUserInfo = Userinfo::leftjoin('restaurant', 'userinfo.restaurantid', '=', 'restaurant.restaurantid')
                                ->select('userinfo.*','restaurant.name' )
                                ->where(function ($query) use ($search,$searchByGender,$searchByUsertype,$searchByStatus) {
                                    $query->where('userinfo.fullname', 'LIKE',"%{$search}%")
                                        ->orwhere('userinfo.gender', $searchByGender )
                                        ->orwhere('userinfo.email', 'LIKE',"%{$search}%")
                                        ->orWhere('userinfo.contactno','LIKE',"%{$search}%")
                                        ->orWhere('userinfo.usertype',$searchByUsertype)
                                        ->orWhere('userinfo.isactive',$searchByStatus)
                                        ->orWhere('restaurant.name', 'LIKE',"%{$search}%");
                                })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ;
                                // ->get();

            $totalFiltered = Userinfo::leftjoin('restaurant', 'userinfo.restaurantid', '=', 'restaurant.restaurantid')
                                ->select('userinfo.*','restaurant.name' )
                                ->where(function ($query) use ($search,$searchByGender,$searchByUsertype,$searchByStatus) {
                                    $query->where('userinfo.fullname', 'LIKE',"%{$search}%")
                                        ->orwhere('userinfo.gender', $searchByGender )
                                        ->orwhere('userinfo.email', 'LIKE',"%{$search}%")
                                        ->orWhere('userinfo.contactno','LIKE',"%{$search}%")
                                        ->orWhere('userinfo.usertype',$searchByUsertype)
                                        ->orWhere('userinfo.isactive',$searchByStatus)
                                        ->orWhere('restaurant.name', 'LIKE',"%{$search}%");
                                })
                                ;
                                // ->count();
            switch ($restaurantID) 
            {
                case '-1':
                    $allUserInfo = $allUserInfo->get();
                    $totalFiltered = $totalFiltered->count();
                    break;
                default:
                    $allUserInfo = $allUserInfo->where('userinfo.restaurantid',$restaurantID)->get();
                    $totalFiltered = $totalFiltered->where('userinfo.restaurantid',$restaurantID)->count();
                    break;
            }

        }
        $data = array();
        if(!empty($allUserInfo))
        {
            foreach ($allUserInfo as $userInfo)
            {
                $edit               = route('userinfo.edit',$userInfo->userid);
                $resetPassword      = route('userinfo.resetpassword',$userInfo->userid);
                $userStatus         = $userInfo->isactive == 1 ? 'Active' : 'Inactive' ;
                $userStatusClass    = $userInfo->isactive == 1 ? 'success' : 'danger' ;

                $nestedData['slno']             = ++$start ;
                $nestedData['name']             = $userInfo->fullname;
                $nestedData['gender']           = $alluserGender[$userInfo->gender];
                $nestedData['email']            = $userInfo->email;
                $nestedData['contactno']        = $userInfo->contactno;
                // $nestedData['image']            = !is_null($userInfo->thumbnail) ? "<img src='".$imgURL."' >" : '' ;
                $nestedData['usertype']         = $alluserType[$userInfo->usertype];
                $nestedData['status']           = "<span class='label label-sm label-{$userStatusClass}'> {$userStatus} </span>";
                $nestedData['action']           = "&emsp;<a href='{$edit}' class='btn btn-circle btn-xs purple'><i class='fa fa-edit'></i> Edit </a>
                                                   &emsp;<a href='{$resetPassword}' class='btn btn-circle btn-xs red'><i class='fa fa-edit'></i> Reset Password </a>";

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('userinfo.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserinfostoreRequest $request)
    {
        $this->_setProfileInfo();

        $all = $request->all();
        
        $userCheck = Userinfo::where('email',$request->input('email'))
                            ->orwhere('contactno',$request->input('mobileNo'))
                            ->get();
        if (count($userCheck) > 0) {
            session()->flash('message', 'User already exists! ');
            session()->flash('class', '2');
            return redirect()->back()->withInput();
        }

        $dob = convertToMySQLDate( $request->input('dob') ) ;

        // $branchIDs = $request->input('userType') == -1 ? array('-1') : ( $request->input('branch') != NULL ? $request->input('branch') : array() );
        $userType = $request->input('userType') ;
        switch ($userType) {
            case '-1':
                $kitchenIDs = array();
                break;
            case '1' :
                // $branchIDs = Branch::select('branchid')->where('restaurantid',$request->input('restaurant'))->get();
                $kitchenIDs = array();
                break;
            default:
                $kitchenIDs = $request->input('kitchen');
                break;
        }

        $data = array(
            'fullname'        => $request->input('fullName'),
            'email'           => $request->input('email'),
            'password'        => Hash::make($request->input('password')),
            'contactno'       => $request->input('mobileNo'),
            'dateofbirth'     => $dob,
            'gender'          => $request->input('gender'),
            'smspinstatus'    => 2,
            'restaurantid'    => $request->input('userType') == -1 ? -1 : $request->input('restaurant'),
            // 'branchid'        => implode(',', $branchId),
            'usertype'        => $request->input('userType'),
            'created_by'      => $this->_profileID,
            'isactive'        => 1
        );    
        
        $userData = Userinfo::firstOrCreate($data);
        $kitchenData = array();
        foreach ($kitchenIDs as $kitchenID) 
        {
            $kitchenData[] = array(
                'userid'        => $userData->userid,
                'restaurantid'  => $userData->restaurantid,
                'kitchenid'      => $kitchenID,
                'created_by'    => $this->_profileID
            );
        }

        UserKitchenMap::insert($kitchenData);

        session()->flash('message', 'New User Created Successfully !');
        session()->flash('class', '1');
        return redirect()->route('userinfo.index');
        
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
        $userInfo = Userinfo::find($id);
        // dd($userInfo->branchID);
        $alluserType = getUserTypeByUser(); 
        return view('userinfo.edit',compact('userInfo','alluserType' ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserinfoeditRequest $request)
    {
        $this->_setProfileInfo();
        /**
        * validation rules
        */
        // $rules = array(
        //     'fullName'              => 'required|max:150',
        //     'mobileNo'              => 'max:20|required',
        //     'email'                 => 'email',
        //     'userType'              => 'required',
        // );

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails())
        // {
        //     $errors = $validator->messages()->toArray();

        //     return  redirect()->back()
        //                     ->withErrors($validator)
        //                     ->withInput();
        // }
        // else
        // {
            $dob = convertToMySQLDate( $request->input('dob') ) ;
            $userID = $request->input('userId');
            // $branchIDs = $request->input('userType') == -1 ? array('-1') : $request->input('branch') ;
            // dd($branchIDs);
            $userType = $request->input('userType') ;
            switch ($userType) 
            {
                case '-1':
                    $kitchenIDs = array();
                    break;
                case '1' :
                    // $branchIDs = Branch::select('branchid')->where('restaurantid',$request->input('restaurant'))->get();
                    $kitchenIDs = array();
                    break;
                default:
                    $kitchenIDs = $request->input('kitchen');
                    break;
            }
            $data = array(
                'fullname'        => $request->input('fullName'),
                // 'email'           => $request->input('email'),
                'contactno'       => $request->input('mobileNo'),
                'dateofbirth'     => $dob,
                'gender'          => $request->input('gender'),
                'usertype'        => $request->input('userType'),
                'restaurantid'    => $request->input('userType') == -1 ? -1 : $request->input('restaurant'),
                // 'branchid'        => implode(',', $branchIDs),
                'updated_by'      => $this->_profileID,
                'isactive'        => $request->input('isActive')

            );  

            $updateUserinfo = Userinfo::where('userid',$userID)->update($data);

            if ($updateUserinfo > 0) 
            {
                if ( $userType != -1 && $userType != 1 )  
                {
                    $kitchenMapData = UserKitchenMap::where('restaurantid',$request->input('restaurant'))
                                                ->where('userid',$userID)
                                                ->delete();
                    $kitchenData = array();
                    foreach ($kitchenIDs as $kitchenID) 
                    {
                        $kitchenData[] = array(
                            'userid'        => $userID,
                            'restaurantid'  => $request->input('restaurant'),
                            'kitchenid'      => $kitchenID,
                            'created_by'    => $this->_profileID
                        );
                    }
                    UserKitchenMap::insert($kitchenData);

                }
                $message = "User Updated Successfully !" ;
                $class = 1;
            }
            else
            {
                $message = "No user found ! Something went wrong !" ;
                $class = 2;
            }
            session()->flash('message', $message );
            session()->flash('class', $class );
            return redirect()->route('userinfo.index');

        // }
    }

    /**
     * Reset the specific user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request,$id)
    {
        $this->_setProfileInfo();

        if( $request->isMethod('post') ) 
        {
            $rules = array(
                'password'              => 'required|min:4',
                'password_confirmation' => 'min:4|same:password'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
            {
                $errors = $validator->messages()->toArray();

                return  redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
            }
            else
            {
                $userInfo = Userinfo::find($id);
                $userInfo->password     = Hash::make($request->input('password'));
                $userInfo->updated_by   = $this->_profileID;
                $userInfo->save();

                session()->flash('message', 'Password Reset Successfully !' );
                session()->flash('class', '1' );
                return redirect()->back() ;
            }
        }
        else
        {
            $userInfo = Userinfo::find($id);
            return view( 'userinfo.reset_password',compact('userInfo') );
        }

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

    /**
     * Ajax function for get the branches according to restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getkitchen(Request $request)
    {
        // return $request;
        $restaurantid = $request->input('res_id');
        $kitchens = getKitchens($restaurantid);

        if( count($kitchens) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $kitchens
        ];
        return json_encode($data);
    }
}
