<?php
namespace JCI\Base\Http\Event;

use JCI\Base\Event\Event;
use JCI\Base\Application\Contracts\Response as ResponseContract;

class ResponseEvent extends Event
{
    use HttpEvent;

    /**
     * @param string $name
     * @param Response $response
     */
    public function __construct($name, ResponseContract $response)
    {
        $this->setName($name);
        $this->setResponse($response);
    }
}
