<?php

namespace Pondit\Validation;

use Pondit\Response\Responsable;

class Validator
{

    Use Responsable;

    /**
     * @param $request
     * @return array
     */
    public static function validate($request)
    {
        $errors = [];
        foreach ($request as $field){
            $rules = explode('|', $field['rules']);
            foreach ($rules as $rule){
                $error = '';
                if($rule === 'email')
                    $error = (new ValidationStrategy(
                        new Email($field['name'], $field['value'])
                    ))->validate();
                else if($rule === 'numeric')
                    $error = (new ValidationStrategy(
                        new Numeric($field['name'], $field['value'])
                    ))->validate();
                else if($rule === 'required')
                    $error = (new ValidationStrategy(
                        new Required($field['name'], $field['value'])
                    ))->validate();

                if($error)
                    $errors[$field['name']][] = $error;
            }
        }

        return $errors;
    }
}
