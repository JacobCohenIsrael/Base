<?php
namespace JCI\Base\Application\Contracts;

use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\ServiceManager\Contracts\ServiceManager;

interface Application
{
    /**
     * @param Request $request
     * @return Response
     */
    public function run(RequestContract $request);
    
    /**
     * @return ServiceManager
     */
    public function getServiceManager();
    
    /**
     * @param ExceptionHandler $eh
     */
    public function registerExceptionHandler(ExceptionHandler $eh);
}

