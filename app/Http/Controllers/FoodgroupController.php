<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Foodgroup;
use App\Models\Category;

use App\Http\Requests\FoodgroupRequest;

use Image;
use File;

class FoodgroupController extends Controller
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
        return view('foodgroup.index'); 
    }

    # AJAX for ALL Food group info 
    public function getFoodgroupInfo(Request $request)
    {
        $allKitchen = getKitchensByUserType();

        $columns = array(
                        0   => "slno" ,
                        1   => "kitchenname" ,
                        2   => "categoryname" ,
                        3   => "foodgroupname" ,
                        4   => "image" ,
                        5   => "detail" ,
                        6   => "status" ,
                        7   => "action" ,
                    );

        $DBcolumns = array(
                        0   => "foodgroupid" ,
                        1   => "kitchen.kitchenname" ,
                        2   => "category.name" ,
                        3   => "foodgroupname" ,
                        4   => "thumbnail" ,
                        5   => "otherdetail" ,
                        6   => "status" ,
                        7   => "foodgroupid" ,
                    );

        $totalData = Foodgroup::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $allFoodgroupInfo = Foodgroup::whereIn('foodgroup.kitchenid',$allKitchen)
                                ->join('kitchen', 'foodgroup.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'foodgroup.categoryid', '=', 'category.categoryid')
                                ->select('foodgroup.*','kitchen.kitchenname','category.name as categoryname')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchByStatus = 999 ;

            switch (strtolower($search)) 
            {
                case 'published':
                    $searchByStatus = 1; 
                    break;
                case 'not published':
                    $searchByStatus = 0; 
                    break; 
                default:
                    $searchByStatus = 999; 
                    break;
            }
            

            $allFoodgroupInfo = Foodgroup::whereIn('foodgroup.kitchenid',$allKitchen)
                                ->join('kitchen', 'foodgroup.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'foodgroup.categoryid', '=', 'category.categoryid')
                                ->select('foodgroup.*','kitchen.kitchenname','category.name as categoryname')
                                ->where(function ($query) use ($search,$searchByStatus) {
                                    $query->where('foodgroup.foodgroupname',$search)
                                        ->orWhere('foodgroup.status', $searchByStatus)
                                        ->orWhere('category.name', 'LIKE',"%{$search}%")
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%");
                                })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

            $totalFiltered = Foodgroup::whereIn('foodgroup.kitchenid',$allKitchen)
                                ->join('kitchen', 'foodgroup.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'foodgroup.categoryid', '=', 'category.categoryid')
                                ->select('foodgroup.*','kitchen.kitchenname','category.name as categoryname')
                                ->where(function ($query) use ($search,$searchByStatus) {
                                    $query->where('foodgroup.foodgroupname',$search)
                                        ->orWhere('foodgroup.status', $searchByStatus)
                                        ->orWhere('category.name', 'LIKE',"%{$search}%")
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%");
                                })
                                ->count();
        }
        $data = array();
        if(!empty($allFoodgroupInfo))
        {
            foreach ($allFoodgroupInfo as $foodgroupInfo)
            {
                $edit               = route('foodgroup.edit',$foodgroupInfo->foodgroupid);
                $foodStatus         = $foodgroupInfo->status == 1 ? 'Published' : 'Not Published' ;
                $foodStatusClass    = $foodgroupInfo->status == 1 ? 'success' : 'danger' ;
                $imgURL             = url('upload/menugroup/'.$foodgroupInfo->thumbnail) ;

                $nestedData['slno']             = ++$start ;
                $nestedData['kitchenname']       = $foodgroupInfo->kitchenname;
                $nestedData['categoryname']     = $foodgroupInfo->categoryname;
                $nestedData['foodgroupname']    = $foodgroupInfo->foodgroupname;
                $nestedData['image']            = !is_null($foodgroupInfo->thumbnail) ? "<img src='".$imgURL."' >" : '' ;
                $nestedData['detail']           = $foodgroupInfo->otherdetail;
                $nestedData['status']           = "<span class='label label-sm label-{$foodStatusClass}'> {$foodStatus} </span>";
                $nestedData['action']           = "&emsp;<a href='{$edit}' class='btn btn-circle btn-xs purple'><i class='fa fa-edit'></i> Edit </a>";

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
        $restaurantID = session()->get('doorstepuser.restaurantid') ;
        $allKitchen=getKitchensbyRestaurant($restaurantID);

        return view('foodgroup.create',compact('allKitchen'));
    }

    public function store(FoodgroupRequest $request)
    {

        $this->_setProfileInfo();   

        $data = array(
                    'kitchenid'         => $request->input('kitchen'),
                    'foodgroupname'     => $request->input('foodgroupname'),
                    'otherdetail'       => $request->input('otherdetail'),
                    'categoryid'        => $request->input('categoryid'),
                    'status'            => $request->input('status'),
                    'created_by'        => $this->_profileID
                );
        Foodgroup::firstOrCreate($data);

        session()->flash('message', 'New Food Group Added Successfully !');
        session()->flash('class', '1');
        return redirect()->route('foodgroup.index');
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
        $restaurantID = session()->get('doorstepuser.restaurantid') ;
        $allKitchen=getKitchensbyRestaurant($restaurantID);

        $foodgroup = Foodgroup::find($id);

        if (count($foodgroup) > 0 ) 
        {
            $Category = Category::where('kitchenid', $foodgroup->kitchenid )->get();
            $allCategory = array();
            foreach ($Category as $cat)
            {
                $allCategory[$cat->categoryid] = $cat->name  ; 
            }

            return view('foodgroup.edit',compact('foodgroup','allKitchen','allCategory'));
        }
        else
        {
            session()->flash('message', 'Could not find the group !');
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
    public function update(FoodgroupRequest $request)
    {
        $this->_setProfileInfo();
        $foodgroupid = $request->input('foodgroupid');


        $data = array(
                'kitchenid'          => $request->input('kitchen'),
                'foodgroupname'     => $request->input('foodgroupname'),
                'otherdetail'       => $request->input('otherdetail'),
                'categoryid'        => $request->input('categoryid'),
                'status'            => $request->input('status'),
                'created_by'        => $this->_profileID
            );

        $updateInfo = Foodgroup::where('foodgroupid',$foodgroupid)->update($data);
        if ($updateInfo > 0) {
            $message = "Food Group Updated Successfully !" ;
            $class = 1;
        }else{
            $message = "No food group found ! Something went wrong !" ;
            $class = 2;
        }
        session()->flash('message', $message );
        session()->flash('class', $class );
        return redirect()->route('foodgroup.index');
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


    // public function getcategorybybranch(Request $request)
    // {
    //     $branchID = $request->input('branch_id');
    //     $allCatData = Category::where('is_active',1)
    //                             ->where('branchid',$branchID)
    //                             ->get();
    //     $allCat = array();
    //     foreach ($allCatData as $category)
    //     {
    //         $allCat[] = array(
    //             'categoryid'   => $category->categoryid,
    //             'categoryname' => $category->name
    //         );    
    //     }

    //     if( count($allCat) > 0 ) {
    //         $msg = "success";
    //     } else {
    //         $msg = "nodata";
    //     }
    //     $data = [
    //         'msg' => $msg,
    //         'data' => $allCat
    //     ];
    //     return json_encode($data);
    // }
}
