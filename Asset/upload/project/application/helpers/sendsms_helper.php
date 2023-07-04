<?php
require APPPATH. 'third_party/twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client;
function SendSms($to,$body){
     // Get a reference to the controller object
     $CI = get_instance();

     // You may need to load the model if it hasn't been pre-loaded
     $CI->load->model('comman_model');

     $account_sid = "ACCOUNT_ID";
     $auth_token = "AUTH_TOKEN";
     $twilio_phone_number = "TWILIO_PHONE_NO";

     $client = new Client($account_sid, $auth_token);

     $client->messages->create(
         $to,
         array(
             "from" => $twilio_phone_number,
             "body" => $body,
         )
     );

}
?>
