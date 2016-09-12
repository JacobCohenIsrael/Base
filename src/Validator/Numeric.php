<?php
namespace JCI\Base\Validator;

class Numeric implements ValidatorInterface
{

    public function getMessage()
    {
        return 'The value has to be a number';
    }

    public function validate($content)
    {
        return is_numeric($content);
    }
}