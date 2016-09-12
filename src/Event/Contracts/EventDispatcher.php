<?php
namespace JCI\Base\Event\Contracts;

interface EventDispatcher
{
    public function dispatch($name, Event $event = null);
}
