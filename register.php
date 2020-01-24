<?php
require_once 'vendor/autoload.php';

$user = new \Pondit\Auth\Register();
$user->setData($_POST)->register();
