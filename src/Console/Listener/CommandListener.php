<?php
namespace JCI\Base\Console\Listener;

use JCI\Base\Event\Listener;
use JCI\Base\Console\Event\ConsoleEvents;
use JCI\Base\Console\Event\RequestEvent;
use JCI\Base\Event\Contracts\EventSubscriber as EventSubscriberContract;
use JCI\Base\Config\ArrayConfig;
use JCI\Base\Console\Exception\CommandNotFound;

class CommandListener implements EventSubscriberContract
{
    /**
     * @var ArrayConfig
     */
    protected $commands;
    
    /**
     * @param ArrayConfig $routes
     */
    public function __construct(ArrayConfig $commands)
    {
        $this->commands = $commands;
    }
    
    /**
     * @param RequestEvent $event
     * @throws CommandNotFound
     */
    public function onRequestEvent(RequestEvent $event)
    {
        $request    = $event->getRequest();
        $command    = $request->getCommand();
        
        if (!$this->commands->has($command)) {
            throw new CommandNotFound("error, command '$command' not found");
        }
        $options    = $this->commands->get($command);

        if ($options->has('controller') && $options->has('action')) {
            $request->setController($options->controller)->setAction($options->action)->setArguments($options->vars, $options->flags);
        } else {
            throw new CommandNotFound("error, command '$command' is not configured properly");
        }
       
    }
    
    /**
     * @return array
     */
    public function getListeners()
    {
        return [
            new Listener(ConsoleEvents::REQUEST, [$this, 'onRequestEvent'])
        ];
    }
}