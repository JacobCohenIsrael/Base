<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Application\Contracts\Request as RequestContract;

trait RequestConstructor
{
    use HttpEvent;
    
    /**
     * @param string $name
     * @param RequestContract $request
     */
    public function __construct($name, RequestContract $request) 
    {
        $this->setName($name)->setRequst($request);
    }
}