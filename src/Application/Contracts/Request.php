<?php
namespace JCI\Base\Application\Contracts;

interface Request
{
    /**
     * @return Application
     */
    public function getApp();
    
    /**
     * @param Application $app
     * @return Request
     */
    public function setApp(Application $app);
    
}
