<?php
namespace JCI\Base\Collection;

use JCI\Base\Collection\Exception\KeyAlreadyExistsException;
use JCI\Base\Collection\Exception\InvalidKeyException;

abstract class Collection implements CollectionInterface, \IteratorAggregate, \JsonSerializable
{
    protected  $items = [];
    
    public function addItem($obj, $key = null) 
    {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (isset($this->items[$key])) {
                throw new KeyAlreadyExistsException("Key $key already exists.");
            } else {
                $this->items[$key] = $obj;
            }
        }
    }

    public function deleteItem($key) 
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new InvalidKeyException("key $key does not exist");
        }
    }

    public function getItem($key) 
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            throw new InvalidKeyException("key $key does not exist");
        }
    }
    
    public function getIterator() {
        return new \ArrayIterator( $this->items );
    }
    
    public function __get($key)
    {
        return $this->items[$key];
    }
    
    public function __set($key, $obj)
    {
        $this->items[$key] = $obj;
    }
    
    public function jsonSerialize()
    {
        return $this->items;
    
    }
}
