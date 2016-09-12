<?php
namespace JCI\Base\Validator;

class Email implements ValidatorInterface
{
    /**
     * @param string $email
     * @return boolean
     */
    public function validate($content)
    {
        return (false !== filter_var($content, FILTER_VALIDATE_EMAIL));
    }
    
    /**
     * @return string
     */
    public function getMessage()
    {
        return 'Invalid email';
    }
}