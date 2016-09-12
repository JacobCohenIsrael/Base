<?php
namespace JCI\Base\Event\Contracts;

interface Event
{
    public function getName();

    public function isStopped();
}