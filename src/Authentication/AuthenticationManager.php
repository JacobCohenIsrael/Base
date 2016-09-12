<?php
namespace JCI\Base\Authentication;

class AuthenticationManager
{
    /**
     * @var AuthenticationStorage
     */
    private $storage;
    
    /**
     * @param AuthenticationStorage $storage
     */
    public function __construct(AuthenticationStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param AuthenticationAdapter $adapter
     */
    public function authenticate(AuthenticationAdapter $adapter)
    {
        $result = $adapter->authenticate();
        if ($result) {
            $this->storage->setIdentity($result);
            return true;
        }
        
        return false;
    }
    
    /**
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->storage->hasIdentity();
    }
    
    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->storage->getIdentity();
    }
    
    /**
     * @return bool
     */
    public function clearIdentity()
    {
        return $this->storage->clearIdentity();
    }
    
    /**
     * @return \JCI\Base\Authentication\AuthenticationStorage
     */
    public function getStorage()
    {
        return $this->storage;
    }
}