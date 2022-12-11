<?php

namespace App\PushNotification;

class PushNotification {

    public function sendGCM($gcmids,$message)
    {
        #API access key from Google API's Console
        $API_ACCESS_KEY = 'AAAAdN6q8pk:APA91bFFO44qgVLfPoT3aj572-cGhkvzalAw_VYF_dl3IC3QIkzJ-b_cW2o8w78lJWDQzVuY1i1uQp2v0YnGklYtRiz0nD-U8CARSOq3ECmTAR-QZc3oQeyAOX4A95RgRB6FmCyNpF5v' ;
        $API_URL        = 'https://fcm.googleapis.com/fcm/send' ;
        // define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
        $registrationIds = $gcmids;
        #Set the time to live
        $ttl = array('ttl' => '30s');
        #prep the bundle
        $fields = array
                (
                    // 'to'                => $GCMID // for single device push 
                    'registration_ids'  =>  $registrationIds , // for multiple device push
                    'data'              => $message ,
                    "android"           => $ttl
                );
        $headers = array
                (
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        // curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_URL, $API_URL );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        #Echo Result Of FireBase Server
        return  json_decode($result);
    }
   
}

?>
