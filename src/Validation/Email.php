<?php

namespace Pondit\Validation;


class Email implements ValidationContract
{

    protected $value, $name;

    public function __construct(string $name, string $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function validate(): string
    {
        if(!filter_var($this->value, FILTER_VALIDATE_EMAIL))
            return "$this->name is not a valid email";

        return "";
    }
}