<?php
namespace JCI\Base\Cache;

interface CacheAdapter
{
    public function get($key, $default = null);
    public function set($key, $value, $expire);
}
