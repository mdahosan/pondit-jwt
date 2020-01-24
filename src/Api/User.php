<?php

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