<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Event\Event;

class RequestEvent extends Event
{
    use RequestConstructor;
}