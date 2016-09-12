<?php
namespace JCI\Base\Validator;

interface ValidatorInterface
{
    public function validate($content);
    
    public function getMessage();
}
