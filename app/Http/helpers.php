<?php
/******************************************
*
*	Custom Helper Function File
*
******************************************/

// if (! function_exists('getDistricts')) {
//     function getDistricts(){
//         $allDistrictData = App\Models\District::all();
        
//         $allDistrict = array();
//         foreach ($allDistrictData as $dis)
//         {
//             $allDistrict[$dis->districtid] = $dis->districtnameen.'('.$dis->districtnamebn.')'  ; 
//         }

//         return $allDistrict ;
//     }
// }

// if (! function_exists('getThana')) {
//     function getThana(){
//         $allThanaData = App\Models\Thana::all();
        
//         $allThana = array();
//         foreach ($allThanaData as $thana)
//         {
//             $allThana[$thana->thanaid] = $thana->thananameen.'('.$thana->thananamebn.')'  ; 
//         }

//         return $allThana ;
//     }
// }

// ### Notification Tag List
// new_order_placed
// incoming_order_rider
// order_cancel

// if (! function_exists('logNotification')) {
//     function logNotification($fromid,$toids,$req,$res,$tag)
//     {
//         $countToids = count($toids);
//         foreach ($res as $response) 
//         {
            
//         }
//     }
// }

if (! function_exists('getAllDeliveryzone')) {
    function getAllDeliveryzone(){
        $allDeliveryzoneData = App\Models\Deliveryzone::where('is_active',1)->orderBy('zonename')->get();
        
        $allZone = array();
        foreach ($allDeliveryzoneData as $zone)
        {
            $allZone[$zone->zoneid] = $zone->zonename; 
        }

        return $allZone;
    }
}

if (! function_exists('getRestaurants')) {
    function getRestaurants(){
        $allRestaurantData = App\Models\Restaurant::where('is_active',1)->get();
        
        $allRestaurant = array();
        foreach ($allRestaurantData as $restaurant)
        {
            $allRestaurant[$restaurant->restaurantid] = $restaurant->name  ; 
        }

        return $allRestaurant ;
    }
}
# Get the restaurants user type wise 
if (! function_exists('getRestaurantByUserType')) {
    function getRestaurantByUserType(){
        // $userID = session()->get('doorstepuser.userid') ;
        $userType = session()->get('doorstepuser.usertype') ;
        $restaurantID = session()->get('doorstepuser.restaurantid') ;

        if ($userType == -1) 
        {
            $allRestaurantData =  App\Models\Restaurant::all() ;
        }
        else
        {
            $allRestaurantData =  App\Models\Restaurant::where('restaurantid',$restaurantID)->get() ;
        }
       
        $allRestaurant = array();
        foreach ($allRestaurantData as $restaurant)
        {
            $allRestaurant[$restaurant->restaurantid] = $restaurant->name  ; 
            // $allRestaurant[] = $restaurant->restaurantid ;
        }
        return $allRestaurant ;
    }
}

if (! function_exists('getRestaurantTypes')) {
    function getRestaurantTypes(){
        $allRestaurantTypeData = App\Models\RestaurantType::where('is_active',1)->get();
        
        $allRestaurantType = array();
        foreach ($allRestaurantTypeData as $type)
        {
            $allRestaurantType[$type->typeid] = $type->typename  ; 
        }

        return $allRestaurantType ;
    }
}



// For ajax call
if (! function_exists('getKitchens')) {
    function getKitchens($id){
        $allKitchenData = App\Models\Kitchen::where('is_active',1)
                                            ->where('restaurantid',$id)
                                            ->get();
        $allKitchen = array();
        foreach ($allKitchenData as $kitchen)
        {
            // $allBranch[$branch->branchid] = $branch->branchname  ; 
            $allKitchen[] = array(
                'kitchenid'   => $kitchen->kitchenid,
                'kitchenname' => $kitchen->kitchenname
            );    
        }
        return $allKitchen ;
    }
}

if (! function_exists('getKitchensbyRestaurant')) {
    function getKitchensbyRestaurant($id){
        $allKitchenData = App\Models\Kitchen::where('is_active',1);
        if ( $id != -1 ) 
        {
            $allKitchenData = $allKitchenData->where('restaurantid',$id);
        }
        $allKitchenData = $allKitchenData->get();    
                                            
                                            
        $allKitchen = array();
        foreach ($allKitchenData as $kitchen)
        {
            $allKitchen[$kitchen->kitchenid] = $kitchen->kitchenname  ; 
        }

        return $allKitchen ;
    }
}


# Get the brances user type wise 
if (! function_exists('getKitchensByUserType')) {
    function getKitchensByUserType(){
        $userID = session()->get('doorstepuser.userid') ;
        $userType = session()->get('doorstepuser.usertype') ;
        $restaurantID = session()->get('doorstepuser.restaurantid') ;

        if ($userType == -1) 
        {
            $allKitchenData =  App\Models\Kitchen::all() ;
        }
        elseif ($userType == 1) 
        {
            $allKitchenData =  App\Models\Kitchen::where('restaurantid',$restaurantID)->get() ;
        }
        else
        {
            $allKitchenData = App\Models\UserKitchenMap::where('userid',$userID)
                                            ->where('restaurantid',$restaurantID)
                                            ->get();
        }
        $allKitchen = array();
        foreach ($allKitchenData as $kitchen)
        {
            $allKitchen[] = $kitchen->kitchenid ;
        }
        return $allKitchen ;
    }
}


if (! function_exists('getFoodCategoryType')) {
    function getFoodCategoryType(){
        $foodtype = array(
            '1'     => 'Normal Food',
            '2'     => 'Combo/Meal',
            '3'     => 'Add On',
        );

        return $foodtype ;
    }
}

if (! function_exists('getUserType')) {
    function getUserType(){
        $userType = array(
            '-1'    => 'Super Admin',
            '1'     => 'Client Admin',
            '2'     => 'Kitchen Agent',  // Branch Agent
            '3'     => 'Waiter',  // Call Center Agent
            '4'     => 'Runner'  // Delivery Agent
        );

        return $userType ;
    }
}

#Get the list user type wise 
if (! function_exists('getUserTypeByUser')) {
    function getUserTypeByUser(){
        $userType = session()->get('doorstepuser.usertype') ;
        switch ($userType) {
            case '-1':
                $userTypeList = array(
                    '-1'    => 'Super Admin',
                    '1'     => 'Client Admin',
                    '2'     => 'Kitchen Agent',  // Branch Agent
                    '3'     => 'Waiter',  // Call Center Agent
                    '4'     => 'Runner'  // Delivery Agent
                );
                break;
            case '1':
                $userTypeList = array(
                    '2'     => 'Kitchen Agent',  // Branch Agent
                    '3'     => 'Waiter',  // Call Center Agent
                    '4'     => 'Runner'  // Delivery Agent
                );
                break;
            default:
                $userTypeList = array(
                    '3'     => 'Waiter',  // Call Center Agent
                    '4'     => 'Runner' // Delivery Agent
                );
                break;
        }

        return $userTypeList ;
    }
}

if (! function_exists('getUserGender')) {
    function getUserGender(){
        $userGender = array(
            '1'     => 'Male',
            '2'     => 'Female',
            '3'     => 'Other'
        );

        return $userGender ;
    }
}

if (! function_exists('getBloodgroup')) {
    function getBloodgroup(){
        $bloodGroup = array(
            '1'     =>  'O+',
            '2'     =>  'O-',
            '3'     =>  'A+',
            '4'     =>  'A-',
            '5'     =>  'B+',
            '6'     =>  'B-',
            '7'     =>  'AB+',
            '8'     =>  'AB-',              
        );

        return $bloodGroup ;
    }
}

if (! function_exists('getOrderStatus')) {
    function getOrderStatus(){
        $deliveryStatus = array(
            '0'     => 'Placed',
            '1'     => 'Order Placed',
            '2'     => 'Confirmed & Processing',
            '3'     => 'Ready to Pickup',
            '4'     => 'On Way',
            '5'     => 'Delivered',
            '6'     => 'Returned',
            '7'     => 'Damaged',
            '8'     => 'Completed',
            '9'     => 'Canceled by Customer',
            '10'    => 'Canceled',
            '11'    => 'Canceled by Branch Agent',
            '12'    => 'In Pantry',
            '13'    => 'P. Ready to Pickup',
            '14'    => 'P. On Way',
            '15'    => 'P. In Pantry',
            '16'    => 'P. Delivered',
        );

        return $deliveryStatus ;
    }
}

if (! function_exists('getOrderFromList')) {
    function getOrderFromList(){
        $orderfrom = array(
            '1'     => 'Tab',
            '2'     => 'Doorstep',
            '3'     => 'Website',
        );
        return $orderfrom ;
    }
}


if (! function_exists('convertToMySQLDate')) {
    function convertToMySQLDate($date){
        if(empty($date) || is_null($date) ) {
            return NULL;
        }
        $time = strtotime($date);
        $mysqldate = date('Y-m-d H:i:s', $time);

        return $mysqldate ;
    }
}

if (! function_exists('convertMySQLDateToWebFormat')) {
    function convertMySQLDateToWebFormat($date){
        if(empty($date) || is_null($date) ) {
            return NULL;
        }
        $time = strtotime($date);
        $webdate = date('d-m-Y', $time);

        return $webdate ;
    }
}

// 1 for Cashcard
// 2 for Card
// 3 for Credit


// Delivery Status

// 0   Pending
// 1   Accepted By Rider
// 2   On Way
// 3   Delivered
// 4   Returned
// 5   Damaged
// 6   Completed
// 7   P. Delivered