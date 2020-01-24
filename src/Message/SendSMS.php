<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/21/2020
 * Time: 12:03 PM
 */

namespace Pondit\Message;


class SendSMS extends MessageSender
{

    public function send()
    {
        $data = $this->data;

        $errors = \Pondit\Validation\Validator::validate([
            [
                'name' => 'message',
                'value' => $data['message']??'',
                'rules' => 'required',
            ],[
                'name' => 'mobile_number',
                'value' => $data['mobile_number']??'',
                'rules' => 'required|numeric',
            ],
            [
                'name' => 'secret_key',
                'value' => $data['secret_key']??'',
                'rules' => 'required',
            ]
        ]);

        if(count($errors)>0){
            $response = new \Pondit\Response\Response();
            $response->throwError(VALIDATION_ERROR, $errors);
        }

        if($data['secret_key'] !== SMS_SECRETE_KEY){
            $this->throwError(VALIDATION_ERROR, ['secret_key' => ['Invalid key.']]);
        }

        $this->smsAPI($data['mobile_number'], $data['message']);

        return $this->returnResponse(SUCCESS_RESPONSE, 'SMS sent successful.');
    }

    private function smsAPI($mobileNo = null, $message = null )
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => SMS_HOST."/smsapi?api_key=".SMS_API_KEY."&type=text&contacts=".$mobileNo."&senderid=".SMS_SENDER_ID."&msg=".urlencode ($message),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo "cURL Error #:" . $err;
            return false;
        } else {
            //echo $response;
            return true;
        }
    }
}