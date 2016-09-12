<?php
namespace JCI\Base\ServiceManager;

use JCI\Base\ServiceManager\Contracts\ServiceManager as ServiceManagerContract;
use JCI\Base\Config\ArrayConfig;

class ServiceManager implements ServiceManagerContract
{
    const APP_CONFIGURATION = 'Config';
    
    /**
     * @var ArrayConfig
     */
    protected $configration;

    /**
     * @var ArrayConfig
     */
    protected $container;
    
    /**
     * @param ArrayConfig $configration
     */
    public function __construct(ArrayConfig $configration)
    {
        $this->configration = $configration;
        $this->container    = new ArrayConfig();
    }
    
    /**
     * @see \JCI\Base\ServiceManager\Contracts\ServiceManager::get()
     */
    public function get($name)
    {
        $container  = $this->container;
        $conf       = $this->configration;
        
        if (!$container->has($name)) {
            if ($conf->has('factory') && $conf->factory->has($name)) {
                $callback = $conf->factory->get($name);
                $this->set($name, call_user_func($callback, $this));
            }
            elseif ($conf->has('invokable') && $conf->invokable->has($name)) {
                $class = $conf->invokable->get($name);
                $this->set($name, new $class);
            }
            
        }
        return $container[$name];
    }
    
    /**
     * @param string $name
     * @param mixed $value
     * @return \JCI\Base\Contracts\ServiceManager\ServiceManager
     */
    public function set($name, $value)
    {
        $this->container[$name] = $value;
        return $this;
    }
    
    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return $this->container->has($name);
    }
    
    /**
     * @param string $name
     * @param string $callback
     * @return \JCI\Base\Contracts\ServiceManager\ServiceManager
     */
    public function setFactory($name, $callback)
    {
        $conf = $this->configration;
        
        if (!$conf->has('factory')) {
            $factory = new ArrayConfig();
        }
        else {
            $factory = $conf->get('factory');
        }
        $factory->set($name, $callback);
        $conf->set('factory', $factory);
        return $this;
    }
    
    /**
     * @param ArrayConfig $config
     * @return \JCI\Base\ServiceManager\ServiceManager
     */
    public function setAppConfiguration($config)
    {
        $this->set(self::APP_CONFIGURATION, $config);
        return $this;
    }

    /**
     * @return ArrayConfig
     */
    public function getAppConfiguration()
    {
        if ($this->has(self::APP_CONFIGURATION)) {
            return $this->get(self::APP_CONFIGURATION);
        }
        return new ArrayConfig();
    }
}