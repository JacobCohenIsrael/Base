<?php
namespace JCI\Base\Http;

use JCI\Base\Application\Contracts\Response as ResponseContract;
use JCI\Base\Http\Parameters\Headers;
use JCI\Base\Http\Parameters\Carrier;

class Response implements ResponseContract
{
    /**
     * @var \JCI\Base\Http\Parameters\Headers
     */
    public $headers;
    
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $cookies;
    
    /**
     * @var number
     */
    public $status = 200;
    
    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var boolean
     */
    protected $isJson = false;
    
    /**
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->headers  = new Headers();
        $this->cookies  = new Carrier();
        $this->content  = $content;
    }
    
    /**
     * @param string $content
     * @return \JCIBase\Http\HttpResponse
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @param number $code
     * @return \JCI\Base\Http\HttpResponse
     */
    public function setStatus($code)
    {
        $this->status = $code;
        return $this;
    }
    
    /**
     * @return \JCI\Base\Http\Response
     */
    public function setJson()
    {
        $this->headers->setContentType(Headers::TYPE_JSON);
        $this->isJson = true;
        return $this;
    }
    
    /**
     * @return \JCI\Base\Http\Response
     */
    public function setJavascript()
    {
        $this->headers->setContentType(Headers::TYPE_JAVASCRIPT);
        return $this;
    }
    
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        // send HTTP status code
        http_response_code($this->status);
        
        // send headers
        $this->headers->send();
        
        // TODO: cookies

        // return data
        return ($this->isJson) ? json_encode($this->content) : (string)$this->content;
    }
}