<?php
namespace JCI\Base\Console;

use JCI\Base\Application\Contracts\Response as ResponseContract;

class ConsoleResponse implements ResponseContract
{
    /**
     * @var mixed
     */
    protected $content;
    
    
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    /**
     * @param $content
     * @return ConsoleResponse
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        if(is_string($this->content)) {
            return $this->content;
        }
        elseif(is_null($this->content)){
            return "null";
        }
        elseif(is_array($this->content)) {
            return print_r($this->content, true);
        }
        elseif(is_object($this->content)){
           return $this->content->__toString();
        }  else {
            return (string)$this->content;
        }

    }
}