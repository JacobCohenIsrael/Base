<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Application\Contracts\Controller as ContollerContract;

class ControllerEvent extends Event
{
    use HttpEvent;
    
    /**
     * @var ContollerContract
     */
    protected $controller;
    
    /**
     * @param string $name
     * @param ContollerContract $controller
     * @param RequestContract $request
     */
    public function __construct($name, ContollerContract $controller, RequestContract $request)
    {
        $this->setName($name)->setController($controller)->setRequst($request);
    }
    
    /**
     * @return ContollerContract
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * @param ContollerContract $controller
     * @return \JCI\Base\Http\Event\ControllerEvent
     */
    public function setController(ContollerContract $controller)
    {
        $this->controller = $controller;
        return $this;
    }
}
