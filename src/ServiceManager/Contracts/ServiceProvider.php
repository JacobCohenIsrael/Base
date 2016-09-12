<?php
namespace JCI\Base\ServiceManager\Contracts;

interface ServiceProvider
{
    static public function create(ServiceManager $sm);
}