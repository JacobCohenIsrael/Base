<?php
namespace JCI\Base\Console\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Response as ResponseContract;

class ResponseEvent extends Event
{

    /**
     * @var ResponseContract
     */
    protected $response;
    
    /**
     * @param string $name
     * @param Response $response
     */
    public function __construct($name, ResponseContract $response)
    {
        $this->setName($name);
        $this->setResponse($response);
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }
    
    public function getResponse()
    {
        return  $this->response;
    }
}