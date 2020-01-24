<?php

namespace Pondit\Validation;


class Numeric implements ValidationContract
{

    protected $value, $name;

    public function __construct(string $name, string $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function validate(): string
    {
        if(!is_numeric($this->value))
            return "$this->name is not a valid number";

        return "";
    }
}