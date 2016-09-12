<?php
namespace JCI\Base\Http\Listener;

use JCI\Base\Event\Listener;
use JCI\Base\Http\HttpEvents;
use JCI\Base\Http\Exception\UnmatchRoute;
use JCI\Base\Http\Event\RequestEvent;
use JCI\Base\Event\Contracts\EventSubscriber as EventSubscriberContract;
use JCI\Base\Config\ArrayConfig;

class RoutingListener implements EventSubscriberContract
{
    /**
     * @var ArrayConfig
     */
    protected $routes;
    
    /**
     * @param ArrayConfig $routes
     */
    public function __construct(ArrayConfig $routes)
    {
        $this->routes = $routes;
    }
    
    /**
     * @param RequestEvent $event
     * @throws UnmatchRoute
     */
    public function onRequestEvent(RequestEvent $event)
    {
        $request    = $event->getRequest();
        $path       = $request->uri->path;
        
        if (!$this->routes->has($path)) {
            throw new UnmatchRoute("no route for path '$path'");
        }
        
        $options    = $this->routes->get($path);
        
        if ($options->has('controller') && $options->has('action')) {
            $request
                ->setController($options->controller)
                ->setAction($options->action)
                ->setActionArguments($options->get('di', []));
            return;
        }
        
        throw new UnmatchRoute("invalid route definition for '$path'");
    }
    
    /**
     * @return array
     */
    public function getListeners()
    {
        return [
            new Listener(HttpEvents::REQUEST, [$this, 'onRequestEvent'])
        ];
    }
}

