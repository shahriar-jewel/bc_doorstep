<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Image;
use File;

class CategoryController extends Controller
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
        return view('category.index');
    }

    # AJAX for ALL category info 
    public function getCategoryInfo(Request $request)
    {
        $allcategoryType = getFoodCategoryType();
        $allKitchen = getKitchensByUserType();

        $columns = array(
                        0   => "slno" ,
                        1   => "kitchenname" ,
                        2   => "categoryname" ,
                        3   => "detail" ,
                        4   => "categorytype" ,
                        5   => "status" ,
                        6   => "action" ,
                    );

        $DBcolumns = array(
                        0   => "categoryid" ,
                        1   => "kitchen.kitchenname" ,
                        2   => "name" ,
                        3   => "otherdetail" ,
                        4   => "categorytype" ,
                        5   => "is_active" ,
                        6   => "orderid" ,
                    );

        $totalData = Category::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $allCategoryInfo = Category::whereIn('category.kitchenid',$allKitchen)
                                ->join('kitchen', 'category.kitchenid', '=', 'kitchen.kitchenid')
                                ->select('category.*','kitchen.kitchenname')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchByStatus = 999 ;
            $searchByType = 999;
            foreach ($allcategoryType as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchByType = $key; 
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

            $allCategoryInfo = Category::whereIn('category.kitchenid',$allKitchen)
                                ->join('kitchen', 'category.kitchenid', '=', 'kitchen.kitchenid')
                                ->select('category.*','kitchen.kitchenname')
                                ->where(function ($query) use ($search,$searchByType,$searchByStatus) {
                                    $query->where('category.name','LIKE',"%{$search}%")
                                        ->orWhere('category.categorytype', $searchByType)
                                        ->orWhere('category.is_active', $searchByStatus)
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%");
                                })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();

            $totalFiltered = Category::whereIn('category.kitchenid',$allKitchen)
                                ->join('kitchen', 'category.kitchenid', '=', 'kitchen.kitchenid')
                                ->select('category.*','kitchen.kitchenname')
                                ->where(function ($query) use ($search,$searchByType,$searchByStatus) {
                                    $query->where('category.name','LIKE',"%{$search}%")
                                        ->orWhere('category.categorytype', $searchByType)
                                        ->orWhere('category.is_active', $searchByStatus)
                                        ->orWhere('kitchen.kitchenname', 'LIKE',"%{$search}%");
                                })
                                ->count();
        }
        $data = array();
        if(!empty($allCategoryInfo))
        {
            foreach ($allCategoryInfo as $categoryInfo)
            {
                $edit                   = route('category.edit',$categoryInfo->categoryid);
                $imgURL                 = url('upload/menu/thumbnail_images/'.$categoryInfo->originalpicture);
                $categoryStatus         = $categoryInfo->is_active == 1 ? 'Active' : 'Inactive' ;
                $categoryStatusClass    = $categoryInfo->is_active == 1 ? 'success' : 'danger' ;

                $nestedData['slno']             = ++$start ;
                $nestedData['kitchenname']      = $categoryInfo->kitchenname;
                $nestedData['categoryname']     = $categoryInfo->name;
                $nestedData['foodpicture']     = !is_null($categoryInfo->originalpicture) ? "<img src='".$imgURL."' width='100px;'>" : '' ;
                $nestedData['serialno']         = $categoryInfo->serialno;
                $nestedData['categorytype']     = $allcategoryType[$categoryInfo->categorytype];
                $nestedData['status']           = "<span class='label label-sm label-{$categoryStatusClass}'> {$categoryStatus} </span>";
                $nestedData['action']           = "&emsp;<a href='{$edit}' class='btn btn-circle btn-xs blue'><i class='fa fa-edit'></i> Edit </a>";

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

        return view('category.create',compact('allKitchen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->_setProfileInfo();
        $kitchenID = $request->input('kitchen');
        $originalImagename = NULL;
        $thumbImagename = NULL;
        

        if ($request->hasFile('originalpicture')) 
        {
            $photo = $request->file('originalpicture');
            // dd($photo); 
            $foodName = str_replace(' ', '_', $request->input('name') );
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
        $data = array(
                    'kitchenid'         => $kitchenID,
                    'name'              => $request->input('name'),
                    'otherdetail'       => $request->input('otherdetail'),
                    'originalpicture'   => $thumbImagename,
                    'serialno'          => $request->input('serialno'),
                    'is_active'         => $request->input('is_active'),
                    'created_by'        => $this->_profileID
                );
        Category::firstOrCreate($data);
        session()->flash('message', 'New Category Created Successfully !');
        session()->flash('class', '1');
        return redirect()->route('category.index');
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

        $category = Category::find($id);

        if (count($category) > 0 ) 
        {
            return view('category.edit',compact('category','allKitchen'));
        }
        else
        {
            session()->flash('message', 'Could not find the category !');
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
    public function update(CategoryRequest $request)
    {
        $this->_setProfileInfo();
        $categoryid = $request->input('catid');
        $catData = Category::find($categoryid);

        $thumbImagename = $catData->thumbnail;
        $originalImagename = $catData->originalpicture;

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
        $data = array(
                    'kitchenid'     => $request->input('kitchen'),
                    'name'          => $request->input('name'),
                    'otherdetail'   => $request->input('otherdetail'),
                    'originalpicture' => $originalImagename,
                    'serialno'      => $request->input('serialno'),
                    'is_active'     => $request->input('is_active'),
                    'updated_by'    => $this->_profileID
                );

        $updateInfo = Category::where('categoryid',$categoryid)->update($data);
        if ($updateInfo > 0) {
            $message = "Category Updated Successfully !" ;
            $class = 1;
        }else{
            $message = "No category found ! Something went wrong !" ;
            $class = 2;
        }
        session()->flash('message', $message );
        session()->flash('class', $class );
        return redirect()->route('category.index');
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


    public function getcategorybyKitchen(Request $request)
    {
        $kitchenID = $request->input('kitchen_id');
        $allCatData = Category::where('is_active',1)
                                ->where('kitchenid',$kitchenID)
                                ->get();
        $allCat = array();
        foreach ($allCatData as $category)
        {
            $allCat[] = array(
                'categoryid'    => $category->categoryid,
                'categoryname'  => $category->name,
                'categorytype'  => $category->categorytype
            );    
        }

        if( count($allCat) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $allCat
        ];
        return json_encode($data);
    }
}
