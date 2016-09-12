<?php
namespace JCI\Base\Event\Contracts;

interface Listener
{
    public function getName();
    
    public function getCallback();
    
    public function getPriority();
}