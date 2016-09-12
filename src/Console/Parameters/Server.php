<?php
namespace JCI\Base\Console\Parameters;

use JCI\Base\Config\ArrayConfig;

class Server extends ArrayConfig
{
    /**
     * @param Argv
     */
    public function getArgv()
    {
        return new Argv($this->get('argv'));
    }
}