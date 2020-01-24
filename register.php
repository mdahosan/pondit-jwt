<?php
require_once 'vendor/autoload.php';
include 'config/constants.php';

$user = new \Pondit\Auth\Register();
$user->setData($_POST)->register();
