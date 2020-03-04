<?php
include 'src/headers.php';

require_once 'vendor/autoload.php';

$_POST = json_decode(file_get_contents("php://input"),true);

$user = new \Pondit\Auth\Register();
$user->setData($_POST)->register();
