<?php
namespace JCI\Base\Http;

use JCI\Base\Application\Contracts\ApplicationSession;

class HttpSession implements ApplicationSession
{
    public function __construct($array = [])
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (!session_start()) {
                throw new HttpException('unable to start session');
            }
        }
    }
    
    public function get($key, $default = null)
    {
        if (empty($_SESSION))
        {
            return $default;
        }
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
    }
    
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }
    
    public function clear($key)
    {
        unset($_SESSION[$key]);
        return $this;
    }
    
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
}