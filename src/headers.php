<?php
header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods:  GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header ("Access-Control-Expose-Headers: *");
//header("Cache-Control: no-cache, must-revalidate");
header('Access-Control-Max-Age: 1728000');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Authorization,  X-Auth-Token");
