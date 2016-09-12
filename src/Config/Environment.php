<?php
namespace JCI\Base\Config;

// TODO:: Move to core and doc that assumption of the const JCI_ENVINROMENT
class Environment
{
    const DEVELOPEMENT = 'development';
    const SANDBOX      = 'sandbox';
    const STAGING      = 'staging';
    const PRODUCTION   = 'production';
    
    /**
     * @return boolean
     */
    public static function isStaging()
    {
        return self::STAGING == JCI_ENVIRONMENT;
    }
    
    /**
     * @return boolean
     */
    public static function isSandbox()
    {
        return self::SANDBOX == JCI_ENVIRONMENT;
    }
    
    /**
     * @return boolean
     */
    public static function isDevelopement()
    {
        return self::DEVELOPEMENT == JCI_ENVIRONMENT;
    }
    
    /**
     * @return boolean
     */
    public static function isProduction()
    {
        return self::PRODUCTION == JCI_ENVIRONMENT;
    }
}