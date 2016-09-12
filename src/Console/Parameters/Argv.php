<?php
namespace JCI\Base\Console\Parameters;

use JCI\Base\Config\ArrayConfig;
use JCI\Base\Console\Exception\CommandNotFound;

class Argv extends ArrayConfig
{
    /**
     * @param ArrayConfig $argv
     */
    public function __construct(ArrayConfig $argv)
    {
        $arr = $argv->getArrayCopy();
        array_shift($arr);
        $this->exchangeArray($arr);
        $this->set('isCorrect', $this->parseArguments());
    }
    
    /**
     * @return string
     * @throws CommandNotFound
     */
    public function getCommand()
    {
       if($this->get('isCorrect'))
           return $this->get('command');
       else
           throw new CommandNotFound('Command Not Found or Invalid', 500);
    }
    
    /**
     * @return ArrayConfig
     * @throws CommandNotFound
     */
    public function getFlags()
    {
        if($this->get('isCorrect'))
            return $this->get('flags');
         else
            throw new CommandNotFound('Command Not Found or Invalid', 500);
    }
    
    /**
     * @return ArrayConfig
     * @throws CommandNotFound
     */
    public function getVars()
    {
        if($this->get('isCorrect'))
            return $this->get('vars');
            else
                throw new CommandNotFound('Command Not Found or Invalid', 500);
    }
        
    /**
     * @param int $index
     */
    public function getArgument($index)
    {
        if (!isset ($this[$index+2]) ) {
            throw new \Exception("Argument Number $index Not Found", 500);
        }
        return $this[$index+2];
    }
    
    /**
     * @return boolean
     */
    private function parseArguments()
    {
        $command = [];
        $flags   = [];
        $vars    = [];
        $firstCommandPart = false;
        $firstVar         = false;
        foreach ($this as $part) {
            //check for flag, flags are of type -x only
            if(preg_match('/\G-(?P<name>[a-zA-Z0-9]+)(?: +|$)/s', $part, $match)){
                //cannot start with flag
                if(!$firstCommandPart)
                    return false;
                $flags[] = $match['name'];
            }
            //check for variables, variables are of type --x=<value> only
            elseif(preg_match('/\G--(?P<name>[a-zA-Z0-9]+)=(?P<value>\S*?)?(?: +|$)/s', $part, $match)) {
                if(!$firstVar)
                    $firstVar = true;
                $vars[$match['name']] = $match['value'];
            } 
            //check for part of a command
            elseif(preg_match('/\G(?P<name>[a-zA-Z][a-zA-Z0-9\_\-\:]*?)(?: +|$)/s', $part, $match)) {
                //variables must come after he last command part, flags may be in between i.e show -all users
                // but not show --id=123 user
                if($firstVar)
                    return false;
                if(!$firstCommandPart)
                    $firstCommandPart = true;
                $command[] = $match['name'];
            } else {
              //undefined part
              return false;  
            }
        }
        
        $this->set('command', join(' ', $command));
        $this->set('flags', $flags);
        $this->set('vars', $vars);
        return true;
    }
}
