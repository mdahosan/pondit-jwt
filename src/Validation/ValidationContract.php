<?php

namespace Pondit\Validation;


interface ValidationContract
{
    public function __construct(string $name, string $value);

    public function validate(): string;
}