<?php
namespace JCI\Base\Http\Controller;

use JCI\Base\Http\JsonResponse;

class RestController extends Controller
{
    /**
     * @var array
     */
    private $actions = [
        'get'       => 'get',
        'post'      => 'save',
        'delete'    => 'remove',
    ];
    
    /**
     * @throws \RuntimeException
     * @return \JCI\Base\Http\JsonResponse
     */
    public function rest()
    {
        $request    = $this->request;
        $method     = strtolower($request->getMethod());
        $params     = func_get_args();
        
        $id = $request->query->get('id', false);
        
        if (false == $id && 'get' == $method) {
            $action = 'query';  // get without ID means query
        }
        else {
            $action = $this->actions[$method];
            array_unshift($params, $id); // add ID to the params
        }
        
        if (!method_exists($this, $action)) {
            throw new \RuntimeException("rest method '$action' not implemented");
        }
        
        $data = call_user_func_array([$this, $action], $params);
        return new JsonResponse($data);
    }
}