<?php

namespace Pondit\Message;


use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMail extends MessageSender
{

    private $email, $subject, $body, $attachmentPath = null;


    /**
     *
     */
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

            $this->email = $data['email'];
            $this->subject = $data['subject'];
            $this->body = $data['body'];
            $this->attachmentPath = $data['attachment_path'];
//echo $this->attachmentPath;
//die();
            $this->mailgunAPI();
        }catch (\Exception $e){
            $this->throwError(MAILGUN_ERROR, $e->getMessage());
        }

        return $this->returnResponse(SUCCESS_RESPONSE, 'Email sent successful.');
    }

    /**
     *
     */
    private function mailgunAPI()
    {
        // Create the Transport
        $transport = new Swift_SmtpTransport('smtp.mailgun.org', 25, '');
        $transport->setUsername(MAILGUN_USERNAME)
                  ->setPassword(MAILGUN_PASSWORD);
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $message = new Swift_Message($this->subject);

        /*
         * For attachment
         * */
        if(!is_null($this->attachmentPath)){
            $explodedAttachments = explode('>', $this->attachmentPath);
            foreach ($explodedAttachments as $attachment){
                $explodedAttachmentPath = explode("/", $attachment);
                $attachmentName = end($explodedAttachmentPath);
//            'file:///C:/Users/Pondit/Desktop/abc.PNG'
                $message->attach(
                    Swift_Attachment::fromPath($attachment)->setFilename($attachmentName)
                );
            }
        }

         $message->setFrom(array(MAIL_FROM_ADDRESS => MAIL_FROM_NAME))
            ->setTo(array($this->email))
            ->setBody($this->body);
        // Send the message
        $mailer->send($message);
    }

}