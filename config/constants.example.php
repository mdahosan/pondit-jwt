<?php

define('HOST', 'localhost'); //app url

/*Database*/
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');

/*sms*/
define('SMS_HOST', '');
define('SMS_API_KEY', '');
define('SMS_SENDER_ID', '');
define('SMS_SECRETE_KEY', '');

/*email*/
define('EMAIL_SECRETE_KEY', '');
define('MAIL_FROM_ADDRESS', '');
define('MAIL_FROM_NAME', '');
define('MAILGUN_USERNAME', '');
define('MAILGUN_PASSWORD', '');

/*Security*/
define('JWT_SECRETE_KEY', '');

/*Error Codes*/
define('REQUEST_METHOD_NOT_VALID',		        100);
define('REQUEST_CONTENTTYPE_NOT_VALID',	        101);
define('REQUEST_NOT_VALID', 			        102);
define('VALIDATE_PARAMETER_REQUIRED', 			103);
define('VALIDATE_PARAMETER_DATATYPE', 			104);
define('VALIDATION_ERROR', 			            105);
define('INVALID_USER_PASS', 					108);
define('USER_NOT_ACTIVE', 						109);

define('SUCCESS_RESPONSE', 						200);

/*Server Errors*/
define('JWT_PROCESSING_ERROR',					300);
define('ATHORIZATION_HEADER_NOT_FOUND',			301);
define('ACCESS_TOKEN_ERRORS',					302);
define('MAILGUN_ERROR',					        304);
define('PDO_EXCEPTION',					        305);

define('TOKEN_LIFE_TIME',					    3600); //number of min

?>