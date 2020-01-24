<?php

namespace Pondit\Validation;


use Pondit\Response\Responsable;

class ValidationStrategy
{
    use Responsable;

    protected $validation;

    /**
     * ValidationStrategy constructor.
     * @param ValidationContract $validation
     */
    public function __construct(ValidationContract $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return string
     */
    public function validate()
    {
        return $this->validation->validate();
    }

}