<?php
namespace JCI\Base\Http\Adapters;

interface HttpClientAdapter
{
    public function get($url);
    public function post($url, $params);
}