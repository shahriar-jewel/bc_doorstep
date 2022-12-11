<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralCategory;
use App\Models\GeneralFood;
use Session;

class FoodMenuController extends Controller
{
    public function realGoodFood()
    {
    	Session::forget('bkash_customerid');
    	$gnrl_categories = GeneralCategory::where('is_active',1)->get()->toArray();
    	return view('Website.food.generalcategory',compact('gnrl_categories'));
    }
    public function generalFood(Request $req)
    {
    	$gnrl_foods = GeneralFood::where('categoryid',$req->g_categoryid)
    	->where('status',1)
    	->get()->toArray();

    	$html = '';
    	foreach ($gnrl_foods as $key => $value)
    	 {
    	 	$imageURL = asset('upload/menu/thumbnail_images/'. $value['originalpicture']);
    		$html .= "<div class='col-xs-6 col-sm-4 food-category chicken'>";
    		$html .= "<a class='inner' href='#'>";
    		$html .= "<div class='imgWrap'>";
    		$html .= "<div class='imgWrap'>";
    		$html .= "<img src='".$imageURL."' data-foodid='".$value['id']."' class='food-img' />";
    		$html .= "</div>";
    		$html .= "<div class='title'>";
    		$html .= "<span style='color:".$value['foodnamecolor'].";text-transform: uppercase;'> ".$value['foodname']."</span>";
    		$html .= "</div>";
    		$html .= "</div>";
    		$html .= "</a>";
    		$html .= "</div>";
    		$data = array(
                 'HTML' => $html
             );
    	 }
    	 if(!empty($data))
    	 {
    	 	return json_encode($data);
    	 }
    	 else
    	 {
    	 	return json_encode('nodata');
    	 }
    }
    public function foodDetails(Request $req)
    {
    	$gnrl_food = GeneralFood::find($req->foodid);
    	$imageURL = asset('upload/menu/thumbnail_images/'. $gnrl_food['originalpicture']);

        $html = '';
        $html .= "<section style='background: #FCF1EB;'>";
        $html .= "<div class='content content__body'>";
        $html .= "<div class='container-fluid row-sm-details'>";
        $html .= "<div class='content  order__details' style='margin-top: 60px !important;'>";
        $html .= "<div class='row' style='background: #F08B21; border-radius: 15px !important' >";
        $html .= "<div class='col-md-1 col-xs-1'></div>";
        $html .= "<div class='col-md-7 col-xs-10'>";
        $html .= "<div class='order__details__title' style='text-transform: uppercase;padding-top: 15px;padding-bottom: 15px; font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif; color: #323231'>".$gnrl_food['foodname']."
           </div>";
        $html .= "</div>";
        $html .= "</div></div></div></div>";
        $html .= "<div class='content content__body'>";
        $html .= "<div class='container-fluid'>";
        $html .= "<div class='content  order__details' style='margin-top: 50px !important;margin-bottom: 30px; background: transparent ;'>";
        $html .= "<div class='row row-sm-details' style='padding-top: 30px; padding-bottom: 30px' >";
         $html .= "<div class='col-md-1'> </div>";
         $html .= "<div class='col-md-6'>";
         $html .= "<div>".$gnrl_food['otherdetail']."</div>";
         $html .= "</div>";
         $html .= "<div class='col-md-4'>";
         $html .= "<img src='".$imageURL."' class='img-responsive'>";
         $html .= "</div>";
         $html .= "<div class='col-md-1'></div>";
         $html .= "</div></div></div></div>";
         $html .= "</section>";

         return json_encode($html);
    }
}
