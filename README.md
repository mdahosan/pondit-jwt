<p align="center"><img src="https://pondit.com/ui/frontend/img/logo.png"></p>

## About Pondit JWT

A simple library to encode and decode JSON Web Tokens (JWT) in PHP, conforming to RFC 7519.


## How to use

`copy config/constants.example.php to config/constants.php`

Database Configuration `config/constants.php`

`
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USERNAME', '');
    define('DB_PASSWORD', '');
`

At first create a users(id, name, mobile_number, email, password, is_active) table to your database.
update config/constants.php according your database credential


Available API (Only accept post requests)
 
1. `domain/register.php` (form data: name, email, mobile_number, password)
2. `domain/login.php` (form data: email, password)
3. `domain/profile.php`  content-type: application/json, Authorization: bearer token
4. `domain/send_sms.php` (form data: secret_key, mobile_number, message)
5. `domain/send_email.php` (form data: secret_key, email, subject, body)

## Contributing

Thank you for considering contributing to the Pondit JWT!

## Security Vulnerabilities

If you discover a security vulnerability within Pondit JWT, please send an e-mail to Dev Team via [dev1@pondit.com](mailto:dev1@pondit.com). All security vulnerabilities will be promptly addressed.

## License

The Pondit JWT is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).