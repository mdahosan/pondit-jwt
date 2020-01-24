<?php
require_once 'vendor/autoload.php';
include 'config/constants.php';

use Pondit\Auth\TokenIssuer;

$auth = new TokenIssuer();
$auth->generateToken($_POST);


