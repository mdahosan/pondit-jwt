<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/21/2020
 * Time: 12:03 PM
 */

namespace Pondit\Message;


use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMail extends MessageSender
{

    public function send()
    {
        $data = $this->data;

        $errors = \Pondit\Validation\Validator::validate([
            [
                'name' => 'email',
                'value' => $data['email']??'',
                'rules' => 'required|email',
            ],[
                'name' => 'subject',
                'value' => $data['subject']??'',
                'rules' => 'required',
            ],[
                'name' => 'body',
                'value' => $data['body']??'',
                'rules' => 'required',
            ],[
                'name' => 'secret_key',
                'value' => $data['secret_key']??null,
                'rules' => 'required',
            ]
        ]);

        if(count($errors)>0){
            $response = new \Pondit\Response\Response();
            $response->throwError(VALIDATION_ERROR, $errors);
        }

        if($data['secret_key'] !== EMAIL_SECRETE_KEY){
            $this->throwError(VALIDATION_ERROR, ['secret_key' =>['Invalid key.']]);
        }

        try{
            $this->mailgunAPI($data['email'], $data['subject'], $data['body']);
        }catch (\Exception $e){
            $this->throwError(MAILGUN_ERROR, $e->getMessage());
        }

        return $this->returnResponse(SUCCESS_RESPONSE, 'Email sent successful.');
    }

    private function mailgunAPI($email, $subject, $body)
    {
        // Create the Transport
        $transport = new Swift_SmtpTransport('smtp.mailgun.org', 25, '');
        $transport->setUsername(MAILGUN_USERNAME)
                  ->setPassword(MAILGUN_PASSWORD);
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $message = new Swift_Message($subject);
         $message->setFrom(array(MAIL_FROM_ADDRESS => MAIL_FROM_NAME))
            ->setTo(array($email))
            ->setBody($body);
        // Send the message
        $mailer->send($message);
    }

}