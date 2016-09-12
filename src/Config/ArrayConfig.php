<?php
namespace JCI\Base\Config;

class ArrayConfig extends \ArrayObject
{
    /**
     * Throws exception when item not exists
     * @var book
     */
    protected $throw = true;

    /**
     * @param ArrayConfig $conf
     * @param bool $recursive
     * @return JCI\Base\Config\ArrayConfig
     */
    public function merge(ArrayConfig $conf, $recursive = false)
    {
        $target = $this->getArrayCopy();
        $source = $conf->getArrayCopy();
        $this->exchangeArray(($recursive) ? array_merge_recursive($target, $source) : array_merge($target, $source));
        return $this;
    }
    
    /**
     * @param book $flag
     * @return JCI\Base\Config\ArrayConfig
     */
    public function setThrow($flag)
    {
        $this->throw = (bool)$flag;
        return $this;
    }
    
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists((string)$key);
    }
    
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            $default = $this->offsetGet($key);
        }
        return (is_array($default)) ? new ArrayConfig($default) : $default;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return JCI\Base\Config\ArrayConfig
     */
    public function set($key, $value)
    {
        $this[$key] = $value;
        return $this;
    }
    
    /**
     * @param string $key
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($key)
    {
        $value = $this->get($key);
        if (null === $value && $this->throw) {
            throw new \InvalidArgumentException("Item '$key' does not exist");
        }
        return $value;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
    
    /**
     * @return string
     */
    public function __toString() 
    {
        return print_r($this->getArrayCopy(),true);
        
    }
}