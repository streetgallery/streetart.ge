<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\User;
use App\Log;
use App\Sms;

// use Auth;

function sendSMS($mobile, $text){

        if($mobile != ''){

            $api_key = "eUNnQW9DaXNiaHhwZXZKc3JlamE=";
            $senderID = "westline";
            $action = "send-sms";
            $code = "+995";
            $data = 'api_key=' . urlencode($api_key) .
                '&action=' . urlencode($action) .
                '&to=' . urlencode($code . $mobile) .
                '&from=' . urlencode($senderID).
                '&sms=' . urlencode($text);

            $url= "https://cp.cloudsms.ge/sms/api?".$data;
            $response =  file_get_contents($url);

            $json = json_decode($response);

            if(isset($json->code) && $json->code == 'ok' ){
                return true;
            } else {
                return false;
            }


            /*
             $sender = "ჭესტინე";
             $data = 'key=' . urlencode('ქ1წ2ე3რ4') . '&destination=' . urlencode($mobile) . '&sender=' . urlencode($sender). '&content=' . urlencode($text);
             $url= "http://smsoffice.ge/api/v2/send?".$data;
             $response =  file_get_contents($url);
             return json_decode($response)->Success;
             */

 
        } else {
            return false;
        }


    }





