<?php
require_once 'vendor/autoload.php';

use Pondit\Api\User;

$user = new User();
$user->authenticatedUser();