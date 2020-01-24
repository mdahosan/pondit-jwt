<?php
require_once 'vendor/autoload.php';

use Pondit\Auth\TokenIssuer;

$auth = new TokenIssuer();
$auth->generateToken($_POST);


