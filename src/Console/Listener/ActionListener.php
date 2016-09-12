<?php
namespace JCI\Base\Console\Listener;

use JCI\Base\Event\Contracts\EventSubscriber as EventSubscriberContract;
use JCI\Base\Event\Listener;
use JCI\Base\Console\Event\ActionEvent;
use JCI\Base\Console\Event\ConsoleEvents;

class ActionListener implements EventSubscriberContract
{   
    /**
     * @param ActionEvent $event
     */
    public function onActionEvent(ActionEvent $event)
    {
        $request    = $event->getRequest();
        $event->setAction($request->getAction());
        $args = $request->getArguments();
        $event->setArguments([$args->get('passedVars'), $args->get('passedFlags')]);
    }
    
    /**
     * @return array
     */
    public function getListeners()
    {
        return [
            new Listener(ConsoleEvents::ACTION, [$this, 'onActionEvent'])
        ];
    } 
}