<?php
namespace JCI\Base\Http\Listener;

use JCI\Base\Event\Listener;
use JCI\Base\Http\Response;
use JCI\Base\Http\HttpEvents;
use JCI\Base\Event\Contracts\EventSubscriber as EventSubscriberContract;
use JCI\Base\Http\Event\ActionEvent;
use JCI\Base\Http\Event\ToResponseEvent;

class ActionListener implements EventSubscriberContract
{
    /**
     * @param ActionContract $event
     */
    public function onActionEvent(ActionEvent $event)
    {
        $request        = $event->getRequest();
        $serviceManager = $request->getApp()->getServiceManager();
        
        $arguments      = [];
        
        foreach ($request->getActionArguments() as $name) {
            $arguments[] = $serviceManager->get($name);
        }
        
        $event->setAction($request->getAction());
        $event->setArguments($arguments);
    }
    
    /**
     * @param ToResponseEvent $event
     */
    public function onToResponse(ToResponseEvent $event)
    {
        $response = new Response();
        $response->setContent($event->getRawResponse());
        $event->setResponse($response);
    }
    
    /**
     * @return array
     */
    public function getListeners()
    {
        return [
            new Listener(HttpEvents::ACTION,        [$this, 'onActionEvent']),
        ];
    }
}
