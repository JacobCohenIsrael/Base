<?php
namespace JCI\Base\Console\Event;

use JCI\Base\Console\Event\RequestEvent;

class ActionEvent extends RequestEvent
{
    /**
     * @var string
     */
    protected $action;
    
    /**
     * @var array
     */
    protected $arguments;
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
    
    /**
     * @param string
     * @return ActionEvent
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    /**
     * @param array
     * @return ActionEvent
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

}