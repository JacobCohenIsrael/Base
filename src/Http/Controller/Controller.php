<?php
namespace JCI\Base\Http\Controller;

use JCI\Base\Application\Contracts\Controller as ControllerContract;
use JCI\Base\Application\Contracts\Request as RequestContract;

class Controller implements ControllerContract
{
    /**
     * @var RequestContract
     */
    protected $request;
    
    public function __construct(RequestContract $request)
    {
        $this->request = $request;
    }
    
    /**
     * @return \JCI\Base\Http\Request
     */
    public function request()
    {
        return $this->request;
    }
    
    
}

