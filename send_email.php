<?php
require_once 'vendor/autoload.php';

$mail = new \Pondit\Message\SendMail($_POST);
$mail->send();
