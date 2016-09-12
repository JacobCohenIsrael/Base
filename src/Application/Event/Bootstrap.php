<?php
namespace JCI\Base\Application\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Application;
use JCI\Base\Application\ApplicationEvents;

class Bootstrap extends Event
{
    /**
     * @var Application
     */
    protected $app;
    
    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->setName(ApplicationEvents::BOOTSTRAP);
    }
    
    /**
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }
}