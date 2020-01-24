<?php
require_once 'vendor/autoload.php';
include 'config/constants.php';

$sms = new \Pondit\Message\SendSMS($_POST);
$sms->send();
