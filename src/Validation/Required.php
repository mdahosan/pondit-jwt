<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/21/2020
 * Time: 4:30 PM
 */

namespace Pondit\Validation;


class Required implements ValidationContract
{

    protected $value, $name;

    public function __construct(string $name, string $value)
    {
       $this->name  = $name;
       $this->value = $value;
    }

    public function validate(): string
    {
        if(strlen($this->value) === 0)
            return "$this->name is required";

        return '';
    }
}