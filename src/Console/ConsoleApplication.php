<?php
namespace JCI\Base\Console;

use JCI\Base\Application\Application;
use JCI\Base\ServiceManager\ServiceManager;
use JCI\Base\Application\Contracts\Request;
use JCI\Base\Event\Contracts\Event;
use JCI\Base\Console\Event\RequestEvent;
use JCI\Base\Console\Event\ConsoleEvents;
use JCI\Base\Console\Event\ActionEvent;
use JCI\Base\Console\Event\ControllerEvent;
use JCI\Base\Console\Event\ResponseEvent;

class ConsoleApplication extends Application
{
    /**
     * @var ControllerResolver
     */
    public $controllerResolver;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->dispatcher = $serviceManager->get('EventDispatcher');
        $this->controllerResolver = $serviceManager->get('ControllerResolver');
    }
    
    /**
     * @param ConsoleRequest
     */
    public function run(Request $request = null)
    {
        if (!$request) {
            $request = ConsoleRequest::create();
        }
        if ($request instanceof ConsoleRequest) {
            $request->setApp($this);
            
            $event = $this->dispatchEvent(new RequestEvent(ConsoleEvents::REQUEST, $request));
            
            $controller = $this->controllerResolver->getController($request);
            $event      = $this->dispatchEvent(new ControllerEvent(ConsoleEvents::CONTROLLER, $controller, $request));
            
            $controller = $event->getController();
            $event      = $this->dispatchEvent(new ActionEvent(ConsoleEvents::ACTION, $request));

            $response   = call_user_func_array([$controller, $event->getAction()], $event->getArguments());
            $event      = $this->dispatchEvent(new ResponseEvent(ConsoleEvents::RESPONSE, $response));
            
            return $event->getResponse();
        }
    }    
    
    /**
     * @param Event $event
     * @return Event
     */
    protected function dispatchEvent(Event $event)
    {
        $this->dispatcher->dispatch($event->getName(), $event);
        return $event;
    }
}
