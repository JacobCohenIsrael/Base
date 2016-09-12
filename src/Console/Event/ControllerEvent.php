<?php
namespace JCI\Base\Console\Event;

use JCI\Base\Console\Event\RequestEvent;

class ControllerEvent extends RequestEvent
{
    
    protected $controller;

    public function __construct($name, $controller, $request)
    {
        $this->setName($name)->setController($controller)->setRequst($request);

    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }
}