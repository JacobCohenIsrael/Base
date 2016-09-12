<?php
namespace JCI\Base\Cache;

class MemcacheAdapter implements CacheAdapter
{
    /**
     * @var \Memcache
     */
    protected $memcache;
    
    /**
     * @param string $host
     * @param string $port
     */
    public function __construct($host, $port)
    {
        $this->memcache = new \Memcache();
        if (!$this->memcache->connect($host, $port)) {
            throw new \Exception('Could not connect to memcache on host ' . $host);
        }
    }
    
    public function get($key, $default = null)
    {
        $value = $this->memcache->get($key);
        if (!$value) {
            return $default;
        }
        return $value;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @param number $expire - seconds till expiration from now
     * @return bool
     */
    public function set($key, $value, $expire)
    {
        return $this->memcache->set($key, $value, 0, $expire);
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @param number $expire - seconds till expiration from now
     * @return bool
     */
    public function replace($key, $value, $expire)
    {
        return $this->memcache->replace($key, $value, 0, $expire);
    }
    
    /**
     * @param string $key
     */
    public function delete($key)
    {
        return $this->memcache->delete($key);
    }
    
    public function close()
    {
        return $this->memcache->close();
    }
}
