<?php
require_once 'vendor/autoload.php';
include 'config/constants.php';

use Pondit\Api\User;

$user = new User();

$user->authenticatedUser();