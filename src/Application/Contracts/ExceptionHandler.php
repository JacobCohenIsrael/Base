<?php
namespace JCI\Base\Application\Contracts;

interface ExceptionHandler
{
    public function onException(\Exception $e);
}