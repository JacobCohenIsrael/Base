<?php
namespace JCI\Base\Console;

use JCI\Base\Application\Contracts\ControllerResolver as ControllerResolverContract;
use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Console\Exception\ControllerNotFound;

class ControllerResolver implements ControllerResolverContract
{
    /**
     * @param $request Request
     */
    public function getController(RequestContract $request)
    {
        $name = $request->getController();
        
        if(!$name)
            throw new ControllerNotFound('controller not set');

        // controller class name
        if (false == strpos($name, '::')) {
            return new $name($request);
        }

        // controller factory method
        return call_user_func($name, $request);
    }
}