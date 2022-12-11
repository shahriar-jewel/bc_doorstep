<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memberinfo;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use DB;


class MemberinfoController extends Controller
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
        $all_member = Memberinfo::all();
        $all_gender = getUserGender();
        return view('member.index',compact('all_member','all_gender' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $restaurantID = session()->get('doorstepuser.restaurantid') ;
        // $allBranch=getBranchesbyRestaurant($restaurantID);

        // return view('category.create',compact('allBranch'));
        return view('member.create');
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

        $originalImagename = NULL;
        $thumbImagename = NULL;

        $rules = array(
            'image' => 'required',
            'member_id'=>'required|unique:memberinfo',
            'name'=>'required',
            'contactno'=>'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }else{
        
            $memberData = array(
            "member_id"     => $request->input('member_id'),
            "name"          => $request->input('name'),
            "type"          => $request->input('type'),
            "contactno"     => $request->input('contactno'),
            "image"         => $request->input('imageurl'),
            "isactive"      => $request->input('isactive'),
        );

        $memberInfo = Memberinfo::firstOrCreate($memberData);

        session()->flash('message', 'New Member Created Successfully !');
        session()->flash('class', '1');
        return redirect()->route('member.index');
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
        $member = Memberinfo::find($id);
        if (count($member) > 0 ) 
        {
            return view('member.edit',compact('member'));
        }
        else
        {
            session()->flash('message', 'Could not find the member !');
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
    public function update(Request $request, $id)
    {
        $this->_setProfileInfo();
        
            $memberData = array(
            "member_id"     => $request->input('member_id'),
            "name"          => $request->input('name'),
            "contactno"     => $request->input('contactno'),
            "image"         => $request->input('imageurl'),
            "isactive"      => $request->input('isactive'),
        );
        $flag = DB::table('memberinfo')->where('id',$id)->update($memberData);
        if($flag){
            $request->session()->flash('message', __('Member Updated Successfully'));
            $request->session()->flash('class','1');
            return redirect(route('member.index'));
        }else{
            $request->session()->flash('message', __('No Modification Found!'));
            $request->session()->flash('class','1');
            return redirect(route('member.index'));
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
    public function memberDatatableAjax(Request $req){

        $columns = array(
            0 => 'id',
            1 => 'member_id',
            2 => 'name',
            3 => 'mobile',
            4 => 'address',
            5 => 'mobile',
            6 => 'email',
            7 => 'isactive',
            8 => 'actions'
        );
        $totalData = Memberinfo::count();
        $totalFiltered = $totalData; 

        $limit = $req->get('length');
        $start = $req->get('start');
        $order = $columns[$req->input('order.0.column')];
        $dir   = $req->get('order.0.dir');
        $search_arr  = $req->get('search');
        $search    = $search_arr['value'];

        if(empty($search))
        {
            $servicedata = Memberinfo::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else
        {
            $servicedata = Memberinfo::where('member_id', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('contactno', 'like', '%' . $search . '%')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Memberinfo::where('member_id', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('contactno', 'like', '%' . $search . '%')
            ->count();
        }

        $data = array();
        if($servicedata)
        {
            foreach($servicedata as $sdata)
            {
                $edit               = route('member.edit',$sdata->id);
                $imgURL             = url('upload/member_images/'.$sdata->image) ;
                $no_image           = asset('/imageFolder/no_image.jpg') ;
                $nestedData['member_id']     = $sdata->member_id;
                $nestedData['name']          = $sdata->name;
                $nestedData['contactno']     = $sdata->contactno;
                $nestedData['image']         = !is_null($sdata->image) ? "<img src='".$sdata->image."' width='80px;'>" : "<img src='".$no_image."' width='80px;'>" ;
                $nestedData['isactive']      = $sdata->isactive == 'Y' ? "<span class='success'>Active</span>" : "<span class='success'>Inactive</span>";
                $nestedData['actions']       = "<a href='{$edit}' class='btn btn-circle btn-xs purple'>
                  <i class='fa fa-edit'></i> Edit </a>
                ";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($req->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
        );

        echo json_encode($json_data);
    }
}
