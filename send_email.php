<?php
require_once 'vendor/autoload.php';
include 'config/constants.php';

$mail = new \Pondit\Message\SendMail($_POST);
$mail->send();
