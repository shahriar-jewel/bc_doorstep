<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use App\Models\GeneralCategory;

class GeneralCategoryController extends Controller
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
         $categorylist = GeneralCategory::get()->toArray();
        return view('realgoodfood.generalcategory.index',compact('categorylist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allRestaurant = getRestaurants();
        return view('realgoodfood.generalcategory.create',compact('allRestaurant'));
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
            'name'         => 'required',
            'picture'      => 'required',
            'namecolor'    => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            return  redirect()->back()->withErrors($validator);
        }
        else{

            if ($request->hasFile('picture')) 
            {
                $photo = $request->file('picture');
                $categoryName = str_replace(' ', '_', $request->input('name') );
                $categoryName = preg_replace('/[^A-Za-z0-9\-\_]/', '', $categoryName);

                $randomNumber = rand(10000,99999) ;
                $originalImagename = time().''.$randomNumber.'_org_'.$categoryName.'.'.$photo->getClientOriginalExtension(); 
                $thumbImagename = time().''.$randomNumber.'_thumb_'.$categoryName.'.'.$photo->getClientOriginalExtension(); 

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
            $gnrl_categories               = new GeneralCategory();
            $gnrl_categories->restaurantid = $request->restaurantid;
            $gnrl_categories->name         = $request->name;
            $gnrl_categories->namecolor    = $request->namecolor;
            $gnrl_categories->otherdetail  = $request->otherdetail;
            $gnrl_categories->picture      = $thumbImagename;
            $gnrl_categories->is_active    = $request->is_active;
            $gnrl_categories->created_by   = $this->_profileID;
            $gnrl_categories->save();
            $message = "General Category added successfully !";
            session()->flash('message', $message );
            session()->flash('class', '1');
            return redirect()->route('general-category.index');
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
        $category = GeneralCategory::find($id)->toArray();
        $allRestaurant = getRestaurants();
        return view('realgoodfood.generalcategory.edit',compact('category','allRestaurant'));
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
        $categoryData = GeneralCategory::find($id);
        $thumbImagename = $categoryData->picture;
        
        if ($request->hasFile('picture')) 
            {
                $photo = $request->file('picture');
                $categoryName = str_replace(' ', '_', $request->input('name') );
                $categoryName = preg_replace('/[^A-Za-z0-9\-\_]/', '', $categoryName);

                $randomNumber = rand(10000,99999) ;
                $originalImagename = time().''.$randomNumber.'_org_'.$categoryName.'.'.$photo->getClientOriginalExtension(); 
                $thumbImagename = time().''.$randomNumber.'_thumb_'.$categoryName.'.'.$photo->getClientOriginalExtension(); 

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
            GeneralCategory::where('id',$id)->update(array(
              'restaurantid' => $request->restaurantid,
              'name' => $request->name,
              'namecolor' => $request->namecolor,
              'otherdetail' => $request->otherdetail,
              'picture' => $thumbImagename,
              'is_active' => $request->is_active,
              'created_by' => $this->_profileID
            ));
            $message = "General Category Updated successfully !";
            session()->flash('message', $message );
            session()->flash('class', '1');
            return redirect()->route('general-category.index');
        
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
