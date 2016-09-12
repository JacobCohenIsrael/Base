<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Response as ResponseContract;

class ToResponseEvent extends Event
{
    /**
     * @var mixed
     */
    protected $rawResponse;
    
    /**
     * @var ResponseContract
     */
    protected $response;
    
    /**
     * @param string $name
     * @param mixed $response
     */
    public function __construct($name, $response) {
        $this->setName($name)->setRawResponse($response);
    }
    
    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }
    
    /**
     * @return ResponseContract
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return \JCI\Base\Http\Event\ToResponseEvent
     */
    public function setRawResponse($response)
    {
        $this->rawResponse = $response;
        return $this;
    }
    
    /**
     * @param ResponseContract $response
     * @return \JCI\Base\Http\Event\ToResponseEvent
     */
    public function setResponse(ResponseContract $response)
    {
        $this->response = $response;
        return $this;
    }
}
