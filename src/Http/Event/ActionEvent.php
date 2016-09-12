<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Event\Event;

class ActionEvent extends Event
{
    use RequestConstructor;
    
    /**
     * @var string
     */
    protected $action;
    
    /**
     * @var array
     */
    protected $arguments;
    
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function getArguments()
    {
        return $this->arguments;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }
}

