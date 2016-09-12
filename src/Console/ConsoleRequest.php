<?php
namespace JCI\Base\Console;

use JCI\Base\Application\Contracts\Request;
use JCI\Base\Application\Contracts\Application;
use JCI\Base\Console\Parameters\Server;
use JCI\Base\Console\Parameters\Argv;
use JCI\Base\Console\Exception\RequestNotFound;
use JCI\Base\Config\ArrayConfig;

class ConsoleRequest implements Request
{

    /**
     * @var ConsoleApplication
     */
    protected $app;
    
    /**
     * @var Server
     */
    protected $server;
    
    /**
     * @var Argv
     */
    protected $argv;
    
    /**
     * @var string
     */
    protected $controller;
    
    /**
     * @var string
     */
    protected $action;
    
    /**
     * @var ArrayConfig
     */
    protected $arguments;
    
    public function __construct(Server $server)
    {
        $this->server       = $server;
        $this->argv         = $server->getArgv();
        if(!$this->argv)
            throw new RequestNotFound('error, no request in command line');
    }
    
    /**
     * @return ConsoleApplication
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param ConsoleApplication $app
     * @return ConsoleRequest
     */
    public function setApp(Application $app)
    {
        $this->app = $app;
        return $this;
    }
    
    /**
     * @param string $controller
     * @return ConsoleRequest
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }
    
    /**
     * @param string $controller
     * @return ConsoleRequest
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->argv->getCommand();
    }
    
    /**
     * @return ArrayConfig
     */
    public function getPassedVars()
    {
        return $this->argv->getVars();
    }
     
    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @return ArrayConfig
     */
    public function getArguments()
    {
        return $this->arguments;
    }
    
    /**
     * @param ArrayConfig $vars
     * @param ArrayConfig $flags
     */
    public function setArguments($vars, $flags)
    {
        $this->arguments = new ArrayConfig();
        $this->arguments->set('passedVars', $this->argv->getVars());
        $this->arguments->set('passedFlags', $this->argv->getFlags());
    }
    
    public static function create()
    {
        return new static
        (
            new Server($_SERVER)
        );
    }
}