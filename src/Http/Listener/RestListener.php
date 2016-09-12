<?php
namespace JCI\Base\Http\Listener;

use JCI\Base\Event\Listener;
use JCI\Base\Http\HttpEvents;
use JCI\Base\Event\Contracts\EventSubscriber as EventSubscriberContract;
use JCI\Base\Http\Event\ActionEvent;

class RestListener implements EventSubscriberContract
{
    /**
     * @param ActionContract $event
     */
    public function onAction(ActionEvent $event)
    {
        $request = $event->getRequest();
        
    }
    
    public function getListeners()
    {
        return [
            new Listener(HttpEvents::ACTION, [$this, 'onAction'], 100)
        ];
    }
}
