<?php
namespace JCI\Base\Collection;

interface CollectionInterface
{
    public function addItem($obj, $key = null);
    
    public function deleteItem($key);
    
    public function getItem($key);
}
