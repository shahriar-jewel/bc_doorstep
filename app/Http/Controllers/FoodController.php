<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Food;
use App\Models\Category;
use App\Models\Comboitem;
use App\Models\Foodgroup;
use App\Models\FoodAddonMap;
use App\Models\FoodMealAddonMap;
use App\Models\FoodChannelMap;
use App\Models\FoodChannel;
use App\Http\Requests\FoodRequest;
use Image;
use File;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class FoodController extends Controller
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
        // $allBranch = getBranchesByUserType();
        // $allfood = Food::whereIn('branchid',$allBranch)->get();
        // return view('food.index',compact('allfood')); 

        return view('food.index'); 
    }
    # AJAX for ALL food info 
    public function getFoodInfo(Request $request)
    {
        $allKitchen = getKitchensByUserType();

        $columns = array(
                        0   => "slno" ,
                        1   => "kitchenname" ,
                        2   => "categoryname" ,
                        3   => "foodgroupname" ,
                        4   => "foodname" ,
                        5   => "foodpicture" ,
                        6   => "detail" ,
                        7   => "price" ,
                        8   => "quantity" ,
                        9   => "status" ,
                        10  => "action" ,
                    );

        $DBcolumns = array(
                        0   => "foodid" ,
                        1   => "kitchenid" ,
                        2   => "categoryid" ,
                        3   => "foodgroupid" ,
                        4   => "foodname" ,
                        5   => "thumbnail" ,
                        6   => "otherdetail" ,
                        7   => "price" ,
                        8   => "quantity" ,
                        9   => "status" ,
                        10  => "foodid" ,
                    );

        $totalData = Food::whereIn('kitchenid',$allKitchen)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $allFoodInfo = Food::whereIn('food.kitchenid',$allKitchen)
                                ->join('kitchen', 'food.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'food.categoryid', '=', 'category.categoryid')
                                ->join('foodgroup', 'food.foodgroupid', '=', 'foodgroup.foodgroupid')
                                ->select('food.*','category.name as categoryname','kitchen.kitchenname','foodgroup.foodgroupname')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchFoodStatus = 2 ;
            switch (strtolower($search)) 
            {
                case 'published':
                    $searchFoodStatus = 1; 
                    break;
                case 'not published':
                    $searchFoodStatus = 0; 
                    break; 
                default:
                    $searchFoodStatus = 2; 
                    break;
            }

            $allFoodInfo = Food::whereIn('food.kitchenid',$allKitchen)
                                ->join('kitchen', 'food.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'food.categoryid', '=', 'category.categoryid')
                                ->join('foodgroup', 'food.foodgroupid', '=', 'foodgroup.foodgroupid')
                                ->select('food.*','category.name as categoryname','kitchen.kitchenname','foodgroup.foodgroupname')
                                ->where(function ($query) use ($search,$searchFoodStatus) {
                                    $query->where('food.foodname','LIKE',"%{$search}%")
                                        ->orWhere('food.otherdetail', 'LIKE',"%{$search}%")
                                        ->orWhere('food.price', 'LIKE',"%{$search}%")
                                        ->orWhere('food.status', $searchFoodStatus)
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%")
                                        ->orWhere('category.name', 'LIKE',"%{$search}%")
                                        ->orWhere('foodgroup.foodgroupname', 'LIKE',"%{$search}%");
                                })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

            $totalFiltered = Food::whereIn('food.kitchenid',$allKitchen)
                                ->join('kitchen', 'food.kitchenid', '=', 'kitchen.kitchenid')
                                ->join('category', 'food.categoryid', '=', 'category.categoryid')
                                ->join('foodgroup', 'food.foodgroupid', '=', 'foodgroup.foodgroupid')
                                ->where(function ($query) use ($search,$searchFoodStatus) {
                                    $query->where('food.foodname','LIKE',"%{$search}%")
                                        ->orWhere('food.otherdetail', 'LIKE',"%{$search}%")
                                        ->orWhere('food.price', 'LIKE',"%{$search}%")
                                        ->orWhere('food.status', $searchFoodStatus)
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%")
                                        ->orWhere('category.name', 'LIKE',"%{$search}%")
                                        ->orWhere('foodgroup.foodgroupname', 'LIKE',"%{$search}%");
                                })
                                ->count();
        }
        $data = array();
        if(!empty($allFoodInfo))
        {
            foreach ($allFoodInfo as $foodInfo)
            {
                $edit               = route('food.edit',$foodInfo->foodid);
                $foodStatus         = $foodInfo->status == 1 ? 'Published' : 'Not Published' ;
                $foodStatusLabel    = "label label-sm label-";
                $foodStatusLabel   .= $foodInfo->status == 1 ? 'success' : 'danger' ;
                $imgURL             = url('upload/menu/thumbnail_images/'.$foodInfo->thumbnail) ;

                $nestedData['slno']            = ++$start ;
                $nestedData['kitchenname']      = $foodInfo->kitchenname;
                $nestedData['categoryname']    = $foodInfo->categoryname;
                $nestedData['foodgroupname']   = $foodInfo->foodgroupname;
                $nestedData['foodname']        = $foodInfo->foodname;
                $nestedData['foodpicture']     = !is_null($foodInfo->thumbnail) ? "<img src='".$imgURL."' width='100px;'>" : '' ;
                $nestedData['price']           = sprintf('%0.2f' , $foodInfo->price)." Tk" ;
                $nestedData['quantity']        = $foodInfo->quantity;
                $nestedData['foodstatus']      = "<span class='".$foodStatusLabel."'>".$foodStatus." </span>";
                // $nestedData['created_by'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['action']          = "&emsp;<a href='{$edit}' class='btn btn-circle btn-xs purple'><i class='fa fa-edit'></i> Edit </a>";

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

        return view('food.create',compact('allKitchen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {

        $this->_setProfileInfo();

        $originalImagename = NULL;
        $thumbImagename = NULL;
        

        if ($request->hasFile('originalpicture')) 
        {
            $photo = $request->file('originalpicture');
            // dd($photo); 
            $foodName = str_replace(' ', '_', $request->input('foodname') );
            $foodName = preg_replace('/[^A-Za-z0-9\-\_]/', '', $foodName);

            $randomNumber = rand(10000,99999) ;
            $originalImagename = time().''.$randomNumber.'_org_'.$foodName.'.'.$photo->getClientOriginalExtension(); 
            $thumbImagename = time().''.$randomNumber.'_thumb_'.$foodName.'.'.$photo->getClientOriginalExtension(); 
       
            if( ! File::isDirectory(public_path().'/upload/menu/thumbnail_images')) {
                File::makeDirectory(public_path().'/upload/menu/thumbnail_images', 493, true);
            }
            if( ! File::isDirectory(public_path().'/upload/menu/normal_images')) {
                File::makeDirectory(public_path().'/upload/menu/normal_images', 493, true);
            }

            $destinationPath = public_path().'/upload/menu/thumbnail_images/'.$thumbImagename;
            // $thumb_img = Image::make($photo->getRealPath())->resize(110, 110);
            $thumb_img = Image::make($photo->getRealPath())->widen(512, function($constraint){
                                                                $constraint->upsize(); //this makes sure no upsize
                                                            })->heighten(512, function($constraint){
                                                                $constraint->upsize(); //this constraint makes sure no upsize
                                                            });
            // $thumb_img->save($destinationPath."\\".$thumbImagename,80);
            $thumb_img->save($destinationPath , 80);
                        
            $destinationPath = public_path().'/upload/menu/normal_images';
            $photo->move($destinationPath, $originalImagename);
        }
        
        //Get the category type from category table to set the food type 
        $categoryData   = Category::find($request->input('categoryid'));
        $foodtype       = $categoryData->categorytype;
        $categoryName   = $categoryData->name;

        $price = $request->input('price');
        $data = array(
                    'kitchenid'         => $request->input('kitchen'),
                    'foodname'          => $request->input('foodname'),
                    'otherdetail'       => $request->input('otherdetail'),
                    'categoryid'        => $request->input('categoryid'),
                    'foodgroupid'       => $request->input('foodgroupid'),
                    'originalpicture'   => $originalImagename,
                    'thumbnail'         => $thumbImagename,
                    'price'             => $request->input('price'),
                    'vat'               => $request->input('vat'),
                    'quantity'          => $request->input('quantity'),
                    'status'            => $request->input('status'),
                    'created_by'        => $this->_profileID
                );

        $foodData = Food::firstOrCreate($data);

        session()->flash('message', 'New Food Added Successfully !');
        session()->flash('class', '1');
        return redirect()->route('food.index');
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
         

        $food = Food::find($id);

        if (count($food) > 0 ) 
        {
            $Category = Category::where('kitchenid', $food->kitchenid )->get();
            $allCategory = array();
            foreach ($Category as $cat)
            {
                $allCategory[$cat->categoryid] = array(
                    'categoryname' => $cat->name  , 
                ); 
            }


            $foodGroup = Foodgroup::where('categoryid', $food->categoryid )->get();
            $allFoodgroup = array();
            foreach ($foodGroup as $group)
            {
                $allFoodgroup[$group->foodgroupid] = $group->foodgroupname  ; 
            }

            return view('food.edit',compact('food','allKitchen','allCategory','allFoodgroup'));
        }
        else
        {
            session()->flash('message', 'Could not find the food !');
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
    public function update(FoodRequest $request)
    {
        // dd($request->all());

        $this->_setProfileInfo();
        $foodid = $request->input('foodid');

        $foodData = Food::find($foodid);

        $thumbImagename = $foodData->thumbnail;
        $originalImagename = $foodData->originalpicture;

        if ( $request->hasFile('originalpicture') ) 
        {
            if ( !is_null($originalImagename) || !is_null($thumbImagename) ) {
                if ( File::exists(public_path().'/upload/menu/normal_images/'.$originalImagename) ) {
                    File::delete(public_path().'/upload/menu/normal_images/'.$originalImagename);
                }
                if ( File::exists(public_path().'/upload/menu/thumbnail_images/'.$thumbImagename) ) {
                    File::delete(public_path().'/upload/menu/thumbnail_images/'.$thumbImagename);
                }
            }

            $photo = $request->file('originalpicture');
            $foodName = str_replace(' ', '_', $request->input('foodname') );
            $foodName = preg_replace('/[^A-Za-z0-9\-]/', '', $foodName);

            $randomNumber = rand(10000,99999) ;
            $originalImagename = time().''.$randomNumber.'_org_'.$foodName.'.'.$photo->getClientOriginalExtension(); 
            $thumbImagename = time().''.$randomNumber.'_thumb_'.$foodName.'.'.$photo->getClientOriginalExtension();

            $destinationPath = public_path().'/upload/menu/thumbnail_images/'.$thumbImagename;


            $thumb_img = Image::make($photo->getRealPath())->widen(512, function($constraint){
                                                                $constraint->upsize(); //this makes sure no upsize
                                                            })->heighten(512, function($constraint){
                                                                $constraint->upsize(); //this constraint makes sure no upsize
                                                            });
            // $thumb_img->save($destinationPath."\\".$thumbImagename,80);
            $thumb_img->save($destinationPath , 80);
                        
            // $destinationPath = public_path('upload\menu\normal_images');
            $destinationPath = public_path().'/upload/menu/normal_images';
            $photo->move($destinationPath, $originalImagename);

        }

        $categoryData = Category::select('categorytype')->find($request->input('categoryid'));
        $foodtype = $categoryData->categorytype;

        $price = $request->input('price');

        $data = array(
                'kitchenid'          => $request->input('kitchen'),
                'foodname'          => $request->input('foodname'),
                'otherdetail'       => $request->input('otherdetail'),
                'categoryid'        => $request->input('categoryid'),
                'foodgroupid'       => $request->input('foodgroupid'),
                'originalpicture'   => $originalImagename,
                'thumbnail'         => $thumbImagename,
                'price'             => $request->input('price'),
                'quantity'          => $request->input('quantity'),
                'status'            => $request->input('status'),
                'created_by'        => $this->_profileID
            );

        $updateInfo = Food::where('foodid',$foodid)->update($data);

        if ($updateInfo > 0) {
            $message = "Food Updated Successfully !" ;
            $class = 1;
        }else{
            $message = "No food found ! Something went wrong !" ;
            $class = 2;
        }
        session()->flash('message', $message );
        session()->flash('class', $class );
        return redirect()->route('food.index');
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
    //     $allCatData = Food::where('is_active',1)
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


    public function getFoodgroupByCategory(Request $request)
    {
        $categoryID = $request->input('category_id');
        $allFoodgroupData = Foodgroup::where('status',1)
                                ->where('categoryid',$categoryID)
                                ->get();
        $allGroup = array();
        foreach ($allFoodgroupData as $foodgroup)
        {
            $allGroup[] = array(
                'foodgroupid'   => $foodgroup->foodgroupid,
                'foodgroupname' => $foodgroup->foodgroupname
            );    
        }

        if( count($allGroup) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $allGroup
        ];
        return json_encode($data);
    }

    // For ajax Request
    public function getAddonByBranch(Request $request)
    {
        $branchID = $request->input('branch_id');
        $allFoodAddonData = Food::where('status',1)
                                ->where('foodtype',3)
                                ->where('branchid',$branchID)
                                ->get();
        $allAddon = array();
        foreach ($allFoodAddonData as $food)
        {
            $allAddon[] = array(
                'addonId'   => $food->foodid,
                'addonName' => $food->foodname.' ( '.$food->price.' Tk )'
            );    
        }

        if( count($allAddon) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $allAddon
        ];
        return json_encode($data);
    }
    


    public function getfoodByBranch(Request $request)
    {
        $branchID = $request->input('branch_id');
        // $allFoodData = Food::where('status',1)
        //                         ->where('foodtype',1)
        //                         ->where('branchid',$branchID)
        //                         ->get();
        $allFoodData = Food::where('branchid',$branchID)
                                ->get();
        $allFood = array();
        foreach ($allFoodData as $food)
        {
            $allFood[] = array(
                'itemId'   => $food->foodid,
                'itemName' => $food->foodname.' ( '.$food->price.' Tk )'
            );    
        }

        if( count($allFood) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $allFood
        ];
        return json_encode($data);
    }
}
