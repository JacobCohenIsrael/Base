<?php
namespace JCI\Base\Application\Contracts;

interface ApplicationSession
{
    public function get($key, $default);
    
    public function set($key, $value);
    
    public function clear($key);
    
    public function has($key);
}

