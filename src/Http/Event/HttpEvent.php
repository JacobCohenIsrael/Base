<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Application\Contracts\Response as ResponseContract;

trait HttpEvent
{
    /**
     * @var RequestContract
     */
    protected $request;
    
    /**
     * @var ResponseContract
     */
    protected $response;
    
    /**
     * @return \JCI\Base\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @return \JCI\Base\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @param RequestContract $request
     * @return JCI\Base\Http\Event\HttpEvent
     */
    public function setRequst(RequestContract $request)
    {
        $this->request = $request;
        return $this;
    }
    
    /**
     * @param ResponseContract $response
     * @return JCI\Base\Http\Event\HttpEvent
     */
    public function setResponse(ResponseContract $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function hasResponse()
    {
        return null != $this->response;
    }
}

