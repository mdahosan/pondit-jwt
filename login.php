<?php
include 'src/headers.php';

require_once 'vendor/autoload.php';

use Pondit\Auth\TokenIssuer;

$_POST = json_decode(file_get_contents("php://input"),true);

$auth = new TokenIssuer();
$auth->generateToken($_POST);


