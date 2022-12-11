<?php

namespace App\SMSSend;

use App\Models\SMSLog;

class SMSSend {

    public function send($userid,$mobile_no,$message,$smstype) {

        $encodedMessage= urlencode($message);

        $contextOptions = array(
            "ssl" => array(
                "verify_peer" => FALSE,
                "verify_peer_name" => FALSE,
            ),
        );

        $cli = "Burger%20King";

        $URL = "http://103.9.185.211/smsSendBurgerKing.php?mobile=$mobile_no&message=$encodedMessage&cli=$cli";

        $results = file_get_contents($URL, FALSE, stream_context_create($contextOptions));

        $resultArray = json_decode($results,true);
        if ( $resultArray['success'] ) 
        {
            $str = explode(",", $resultArray['result']);
            $status = $str[0];

            if ($status == 200) {
                $this->smslog($userid,$mobile_no,$message,$smstype,1,$results);
                return true;
            } else {
                $this->smslog($userid,$mobile_no,$message,$smstype,0,$results);
                return false;
            }
        }
        else
        {
            $this->smslog($userid,$mobile_no,$message,$smstype,0,$results);
            return false;
        }
    }

    private function smslog($id,$mobile_no,$message,$smstype,$status,$response){
        $data = array(
            'touserid'   => $id,
            'mobileno'   => $mobile_no,
            'message'    => $message,
            'response'   => $response,
            'smstype'    => $smstype,
            'status'     => $status,
        );
        SMSLog::insert($data);
    }
   
}

?>
