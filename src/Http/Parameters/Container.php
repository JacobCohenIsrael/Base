<?php
namespace JCI\Base\Http\Parameters;

class Container extends \ArrayObject
{
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return (isset($this[$key])) ? $this[$key] : $default;
    }
}