<?php
namespace JCI\Base\Http;

use JCI\Base\Application\Contracts\ControllerResolver as ControllerResolverContract;
use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Http\Exception\ControllerNotFound;

class ControllerResolver implements ControllerResolverContract
{
    /**
     * @param $request Request
     */
    public function getController(RequestContract $request)
    {
        if (!$request->attributes->has(HttpKeys::CONTROLLER)) {
            throw new ControllerNotFound('controller not set');
        }
        $name = $request->attributes->get(HttpKeys::CONTROLLER);
        
        // controller class name
        if (false == strpos($name, '::')) {
            return new $name($request);
        }
        
        // controller factory method
        return call_user_func($name, $request);
    }
}