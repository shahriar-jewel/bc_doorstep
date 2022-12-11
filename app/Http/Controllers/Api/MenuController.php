<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController as ApiController;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Food;
use App\Models\Category;


class MenuController extends ApiController
{

    /**
     * Menu List and detail branch wise .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function menuList(Request $request)
    {

        $allCategory = Category::select()->with('foodgroups.foods')->get();

        $allMenuList = array();

        foreach ($allCategory as $Category ) 
        {
            $foodgroupData = array();
            $exist = false;
            foreach ($Category->foodgroups as $foodgroup ) 
            {
                $foodData = array();
                $hasFood = false;
                foreach ($foodgroup->foods as $food ) 
                {
                    $exist = true; 
                        $hasFood = true;  // set to true if atleast one food item found within the foodgroup 

                        $foodData[] = array(
                            'foodId'        => $food->foodid,
                            'foodName'      => $food->foodname,
                            'kitchenid'     => $food->kitchenid,
                            'foodDetail'    => $food->otherdetail,
                            'foodPrice'     => sprintf( '%0.2f',$food->price),
                            'foodPicture'   => asset('').'upload/menu/thumbnail_images/'.$food->thumbnail,
                            'foodStatus'    => $food->status,
                        );
                    }
                    if ($hasFood) 
                    {
                        $foodgroupData[] = array(
                            'foodgroupId'       => $foodgroup->foodgroupid,
                            'foodgroupName'     => $foodgroup->foodgroupname,
                            'foodgroupDetail'   => $foodgroup->otherdetail,
                            'foods'             => $foodData
                        );
                    }
                }
                

                $categoryData = array(
                    'categoryId'        => $Category->categoryid,
                    'categoryName'      => $Category->name,
                    'categoryDetail'    => $Category->otherdetail,
                    'categoryStatus'    => $Category->is_active,
                    'foodgroups'        => $foodgroupData
                );

                if ( $exist ) 
                {
                    $allMenuList [] = $categoryData ;
                }
            }

            if (count($allMenuList) > 0 ) 
            {
                $msg = "All Menu List " ;
            }
            else
            {
                $msg = "No Data Found !" ;

            }

            return $this->respondWithSuccess($msg,$allMenuList,200);
        }

        public function menuListBCMember(Request $request){

            $limit = 12;
            $page = $request->page && $request->page > 0 ? $request->page : 1;
            $category = $request->category;
            $skip = ($page - 1) * $limit;

            $foods = Food::with('category');
            if($category){
                $foods = $foods->where('categoryid',$category);
                $totalFiltered = Food::where('categoryid',$category)->count();
            }else{
                $foods = $foods->offset($skip)->limit($limit);
                $totalFiltered = Food::count();
            }
            $foods = $foods->get();
            if($category){
                $data = [$foods,'totalCount' => $totalFiltered, 'size' => $totalFiltered, 'page' => 1]; 
            }else{
                $data = [$foods,'totalCount' => $totalFiltered, 'size' => $limit, 'page' => $page];
            }
            $msg = "All Menu List " ;
            return $this->respondWithSuccess($msg,$data,200);
        }


    /**
     * Change Food Status .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function changeFoodstatus(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'foodid'             => 'required',
            'foodstatus'         => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Missing Required Field"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
        else
        {
            $foodID        = $request->input('foodid');
            $foodStatus    = $request->input('foodstatus');
            $userID        = $request->input('userid');

            $updateData = array(
                'status'        => $foodStatus,
                'updated_by'    => $userID
            );

            $updateinfo = Food::where('foodid',$foodID)->update($updateData);

            $statuscode = 200;
            $data = array();
            if ($updateinfo) 
            {
                $msg = "Updated Successfully !" ; 
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }
            else
            {
                $msg = "Something went wrong ! Can not accept or deny !" ; 
                $data = [
                    'error_code'    => "405",
                    'error_msg'     => "Food not found!"
                ];
                return $this->respondWithError($msg,$data,$statuscode);
            }

        }

    }


}
