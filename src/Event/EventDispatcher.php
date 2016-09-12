<?php
namespace JCI\Base\Event;

use JCI\Base\Event\Contracts\EventDispatcher as EventDispatcherContract;
use JCI\Base\Event\Contracts\Listener as ListenerContract;
use JCI\Base\Event\Contracts\EventSubscriber;
use JCI\Base\Event\Contracts\Event as EventContract;

class EventDispatcher implements EventDispatcherContract
{
    /**
     * @var array
     */
    private $listeners = [];
    
    /**
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }
    
    /**
     * @param ListenerContract $listener
     * @return \JCI\Base\Event\EventDispatcher
     */
    public function addListener(ListenerContract $listener)
    {
        $eventName  = $listener->getName();
        $priority   = $listener->getPriority();
        
        $this->listeners[$eventName][$priority][] = $listener->getCallback();
        return $this;
    }
    
    /**
     * @param EventSubscriber $sub
     * @return \JCI\Base\Event\EventDispatcher
     */
    public function addSubscriber(EventSubscriber $sub)
    {
        foreach ($sub->getListeners() as $listener) { /* @var $listener Listener */
            $this->addListener($listener);
        }
        return $this;
    }
    
    /**
     * @param array $subs
     * @return \JCI\Base\Event\EventDispatcher
     */
    public function addSubscribers(array $subs)
    {
        foreach ($subs as $sub) {
            $this->addSubscriber($sub);
        }
        return $this;
    }
    
    /**
     * @param string $name
     * @param EventContract $event
     * @return EventContract
     */
    public function dispatch($name, EventContract $event = null)
    {
        if (null == $event) {
            $event = new Event($name);
        }
        return $this->doDispatch($event);
    }
    
    /**
     * @param EventContract $event
     * @return EventContract
     */
    protected function doDispatch(EventContract $event)
    {
        foreach ($this->getListenersByName($event->getName()) as $listener) {
            call_user_func($listener, $event);
            if ($event->isStopped()) {
                break;
            }
        }
        return $event;
    }
    
    /**
     * Get listeners for event ordered by priority
     *
     * @param string $name
     * @return array
     */
    protected function getListenersByName($name)
    {
        if (!isset($this->listeners[$name])) {
            return [];
        }
        $temp   = $this->listeners[$name];
        ksort($temp);
        $list   = [];
        foreach ($temp as $listeners) {
            foreach ($listeners as $l) {
                $list[] = $l;
            }
        }
        return $list;
    }
}

