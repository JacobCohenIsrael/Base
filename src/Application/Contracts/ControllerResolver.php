<?php
namespace JCI\Base\Application\Contracts;

interface ControllerResolver
{
    public function getController(Request $request);
}