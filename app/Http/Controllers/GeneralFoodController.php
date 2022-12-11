<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralCategory;
use App\Models\GeneralFood;
use Illuminate\Support\Facades\Validator;
use Image;
use File;

class GeneralFoodController extends Controller
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
        $foodlist = GeneralCategory::join('general_foods as gf','gf.categoryid','general_categories.id')
            ->select('gf.id','general_categories.name','gf.foodname','gf.foodnamecolor','gf.originalpicture','gf.status')->get()->toArray();
        return view('realgoodfood.generalfood.foodlist',compact('foodlist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allRestaurant = getRestaurants();
        $allgeneralcategory = GeneralCategory::pluck('name','id');
        
        return view('realgoodfood.generalfood.create',compact('allRestaurant','allgeneralcategory'));
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
            'foodname'         => 'required',
            'foodnamecolor'    => 'required',
            'otherdetail'      => 'required',
            'originalpicture'  => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            return  redirect()->back()->withErrors($validator);
        }
        else{

            if ($request->hasFile('originalpicture')) 
            {
                $photo = $request->file('originalpicture');
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
                $thumb_img = Image::make($photo->getRealPath())->widen(1024, function($constraint){
                        $constraint->upsize(); //this makes sure no upsize
                            })->heighten(1024, function($constraint){
                            $constraint->upsize(); //this constraint makes sure no upsize
                            });
                            $thumb_img->save($destinationPath , 80);
                $destinationPath = public_path().'/upload/menu/normal_images';
                $photo->move($destinationPath, $originalImagename);
            }
            $gnrl_foods               = new GeneralFood();
            $gnrl_foods->categoryid   = $request->categoryid;
            $gnrl_foods->restaurantid = $request->restaurantid;
            $gnrl_foods->foodname         = $request->foodname;
            $gnrl_foods->foodnamecolor    = $request->foodnamecolor;
            $gnrl_foods->otherdetail  = $request->otherdetail;
            $gnrl_foods->originalpicture      = $thumbImagename;
            $gnrl_foods->status    = $request->status;
            $gnrl_foods->created_by   = $this->_profileID;
            $gnrl_foods->save();
            $message = "General Food added successfully !";
            session()->flash('message', $message );
            return redirect()->route('general-food.index');
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
        $food = GeneralFood::find($id)->toArray();
        $allRestaurant = getRestaurants();
        $allgeneralcategory = GeneralCategory::pluck('name','id');
        // dd($food);
        return view('realgoodfood.generalfood.edit',compact('food','allRestaurant','allgeneralcategory'));
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
        $foodData = GeneralFood::find($id);
        $thumbImagename = $foodData->originalpicture;
        
        if ($request->hasFile('originalpicture')) 
            {
                $photo = $request->file('originalpicture');
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
                $thumb_img = Image::make($photo->getRealPath())->widen(1024, function($constraint){
                        $constraint->upsize(); //this makes sure no upsize
                            })->heighten(1024, function($constraint){
                            $constraint->upsize(); //this constraint makes sure no upsize
                            });
                            $thumb_img->save($destinationPath , 80);
                $destinationPath = public_path().'/upload/menu/normal_images';
                $photo->move($destinationPath, $originalImagename);
            }
            GeneralFood::where('id',$id)->update(array(
              'categoryid'      => $request->categoryid,
              'restaurantid'    => $request->restaurantid,
              'foodname'        => $request->foodname,
              'foodnamecolor'   => $request->foodnamecolor,
              'otherdetail'     => $request->otherdetail,
              'originalpicture' => $thumbImagename,
              'status'          => $request->status,
              'created_by'      => $this->_profileID
            ));
            $message = "General Food Updated successfully !";
            session()->flash('message', $message );
            session()->flash('class', '1');
            return redirect()->route('general-food.index');
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
