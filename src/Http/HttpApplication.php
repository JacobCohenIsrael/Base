<?php
namespace JCI\Base\Http;

use JCI\Base\Application\Application;
use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Application\Contracts\Response as ResponseContract;
use JCI\Base\Event\Contracts\Event;
use JCI\Base\Http\Event\ActionEvent;
use JCI\Base\Http\Event\RequestEvent;
use JCI\Base\Http\Event\ResponseEvent;
use JCI\Base\Http\Event\ControllerEvent;
use JCI\Base\Http\Event\ToResponseEvent;
use JCI\Base\Http\Exception\InvalidResponse;
use JCI\Base\ServiceManager\Contracts\ServiceManager;
use JCI\Base\Config\ArrayConfig;
use JCI\Base\Event\EventDispatcher;

class HttpApplication extends Application
{
    /**
     * @var ControllerResolver
     */
    public $controllerResolver;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager = null)
    {
        // need to add the controller resolver before calling parent constructor
        // beacuse application constractor dispatches the bootstrap event
        if (!$this->controllerResolver) {
            $this->controllerResolver = new ControllerResolver();
        }
        
        if (!$serviceManager) {
            $configuration = new ArrayConfig([ 'servicemanager' => [] ]);
            $serviceManager = new \JCI\Base\ServiceManager\ServiceManager($configuration->get('servicemanager'));
            $serviceManager->setAppConfiguration($configuration);
        }
        
        if (!$serviceManager->has('ControllerResolver')) {
            $serviceManager->set('ControllerResolver',  $this->controllerResolver);
        }

        if (!$serviceManager->has('EventDispatcher')) {
            $serviceManager->set('EventDispatcher',     new EventDispatcher());
        }

        $this->controllerResolver = $serviceManager->get('ControllerResolver');
        parent::__construct($serviceManager);
    }
    
    /**
     * @see \JCI\Base\Application\Contracts\Application::run()
     */
    public function run(RequestContract $request = null)
    {
        if (!$request) {
            $request = Request::create();
        }
        $request->setApp($this);
        
        $event      = $this->dispatchEvent(new RequestEvent(HttpEvents::REQUEST, $request));
        if ($event->hasResponse()) {
            return $this->responseEvent($event->getResponse());
        }
        
        $controller = $this->controllerResolver->getController($request);
        $event      = $this->dispatchEvent(new ControllerEvent(HttpEvents::CONTROLLER, $controller, $request));
        
        $controller = $event->getController();
        $event      = $this->dispatchEvent(new ActionEvent(HttpEvents::ACTION, $request));
        
        $response   = call_user_func_array([$controller, $event->getAction()], $event->getArguments());
        
        if (!$response instanceof ResponseContract) {
            $event = $this->dispatchEvent(new ToResponseEvent(HttpEvents::TORESPONSE, $response));
            $response = $event->getResponse();
            if (!$response instanceof ResponseContract) {
                throw new InvalidResponse('invalid response type');
            }
        }
        
        return $this->responseEvent($response);
    }
    
    /**
     * @param Response $response
     * @return \JCI\Base\Application\Contracts\Response
     */
    protected function responseEvent(ResponseContract $response)
    {
        return $this->dispatchEvent(new ResponseEvent(HttpEvents::RESPONSE, $response))->getResponse();
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