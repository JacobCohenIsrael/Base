<?php
namespace JCI\Base\Event;

use JCI\Base\Event\Contracts\Event as EventContract;

class Event implements EventContract
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var bool
     */
    protected $stopped = false;
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return \JCI\Base\Event\Event
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isStopped()
    {
        return $this->stopped;
    }
    
    /**
     * @param string $stop
     * @return \JCI\Base\Event\Event
     */
    public function stopPropagation($stop = true)
    {
        $this->stopped = $stop;
        return $this;
    }
}
