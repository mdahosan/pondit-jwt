<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/20/2020
 * Time: 12:56 PM
 */

namespace Pondit\Api;


use Pondit\Auth\TokenIssuer;

class User extends Rest
{

    public function __construct()
    {
        parent::__construct();
    }

    public function authenticatedUser()
    {
        $user = $this->user();
        return $this->returnResponse(SUCCESS_RESPONSE, $user);
    }
}