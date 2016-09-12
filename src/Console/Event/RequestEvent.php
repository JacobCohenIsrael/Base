<?php
namespace JCI\Base\Console\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Request;

class RequestEvent extends Event
{
    /**
     * @var RequestContract
     */
    protected $request;
    
    /**
     * @param string $name
     * @param Request $request
     */
    public function __construct($name, Request $request) 
    {
        $this->setName($name)->setRequst($request);
    }
    
    /**
     * @return \JCI\Base\Console\ConsoleRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @param Request $request
     * @return \JCI\Base\Console\Event\RequestEvent
     */
    public function setRequst(Request $request)
    {
        $this->request = $request;
        return $this;
    }
}