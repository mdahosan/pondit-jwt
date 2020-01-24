<?php
require_once 'vendor/autoload.php';

$sms = new \Pondit\Message\SendSMS($_POST);
$sms->send();
