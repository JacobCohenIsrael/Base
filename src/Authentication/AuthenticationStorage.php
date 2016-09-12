<?php
namespace JCI\Base\Authentication;

interface AuthenticationStorage
{
    /**
     * @return bool
     */
    public function hasIdentity();
    
    /**
     * @param mixed $object
     */
    public function setIdentity($object);
    
    /**
     * @return bool
     */
    public function clearIdentity();
    
    /**
     * @return mixed
     */
    public function getIdentity();
}