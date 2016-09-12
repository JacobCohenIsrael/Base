<?php
namespace JCI\Base\Model;

abstract class Model
{
    /**
     * @param array $array
     */
    public function __construct($array = [])
    {
        foreach (get_object_vars($this) as $key => $value) {
            if (array_key_exists($key, $array)) {
                $this->$key = $array[$key];
            }
        }
    }    
}
