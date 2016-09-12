<?php
namespace JCI\Base\Application;

use JCI\Base\Application\Contracts\Application as ApplicationContract;
use JCI\Base\Application\Event\Bootstrap as BootstrapEvent;
use JCI\Base\ServiceManager\ServiceManager;
use JCI\Base\Event\Contracts\EventDispatcher;
use JCI\Base\Application\Contracts\ExceptionHandler;
use JCI\Base\Config\ArrayConfig;
use JCI\Base\Application\Contracts\ErrorHandler;

abstract class Application implements ApplicationContract
{
    /**
     * @var EventDispatcher
     */
    public $dispatcher;
    
    /**
     * @var ServiceManagerContract
     */
    public $serviceManager;
    
    /**
     * @var ArrayConfig
     */
    public $attributes;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager       = $serviceManager;
        $this->dispatcher           = $serviceManager->get('EventDispatcher');
        $this->attributes           = new ArrayConfig([]);
        
        $this->dispatcher->dispatch(ApplicationEvents::BOOTSTRAP, new BootstrapEvent($this));
    }
    
    /**
     * @see \JCI\Base\Application\Contracts\Application::getServiceManager()
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
    
    /**
     * @param ExceptionHandler $eh
     * @return callable
     */
    public function registerExceptionHandler(ExceptionHandler $eh)
    {
        return set_exception_handler([$eh, 'onException']);
    }
    
    /**
     * 
     * @param ErrorHandler $eh
     * @return callable
     */
    public function registerErrorHandler(ErrorHandler $eh)
    {
        return set_error_handler([$eh, 'onError']);
    }
}