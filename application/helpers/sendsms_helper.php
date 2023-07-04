<?php
require 'twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client;
function SendSms($to,$body){
     // Get a reference to the controller object
     $CI = get_instance();

     // You may need to load the model if it hasn't been pre-loaded
     $CI->load->model('Comman_model');

     $account_sid = "ACa70e4384b26e5b6be4fc3c10746ef8c6";
     $auth_token = "341c1014108211625fab548973303a55";
     $twilio_phone_number = "+18786458477";

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
