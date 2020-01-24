<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/21/2020
 * Time: 4:28 PM
 */

namespace Pondit\Validation;


interface ValidationContract
{
    public function __construct(string $name, string $value);

    public function validate(): string;
}