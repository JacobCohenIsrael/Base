<?php
namespace JCI\Base\Event;

use JCI\Base\Event\Contracts\Listener as ListenerContract;

class Listener implements ListenerContract
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var callback
     */
    protected $callback;
    
    /**
     * @var number
     */
    protected $priority;
    
    /**
     * @param string $name
     * @param callback $callback
     * @param number $priority
     */
    public function __construct($name, $callback, $priority = 0)
    {
        $this->name     = $name;
        $this->callback = $callback;
        $this->priority = $priority;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return callback
     */
    public function getCallback()
    {
        return $this->callback;
    }
    
    /**
     * @return nubmer
     */
    public function getPriority()
    {
        return $this->priority;
    }
}