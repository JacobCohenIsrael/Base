<?php
namespace JCI\Base\ServiceManager\Contracts;

interface ServiceManager
{
    public function get($name);
    
    public function set($name, $value);
}
