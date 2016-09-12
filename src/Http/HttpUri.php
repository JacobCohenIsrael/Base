<?php
namespace JCI\Base\Http;

use JCI\Base\Http\Parameters\Server;

class HttpUri
{
    /**
     * @var string
     */
    public $scheme;
    
    /**
     * @var string
     */
    public $host;
    
    /**
     * @var string
     */
    public $user;
    
    /**
     * @var string
     */
    public $pass;
    
    /**
     * @var string
     */
    public $path;
    
    /**
     * @var string
     */
    public $query;
    
    /**
     * @var string
     */
    public $fragment;
    
    /**
     * @param Server $server
     * @return \JCI\Base\Http\HttpUri
     */
    static public function createFromServer(Server $server)
    {
        $host   = $server->getHost();
        $uri    = $server->getUri();
        $scheme = $server->isHttps() ? 'https' : 'http';
        
        return new HttpUri("{$scheme}://{$host}{$uri}");
    }
    
    /**
     * @param string $uri
     */
    public function __construct($uri)
    {
        $url = parse_url($uri);
        $this->scheme   = isset($url['scheme'])     ? $url['scheme']    : null;
        $this->host     = isset($url['host'])       ? $url['host']      : null;
        $this->user     = isset($url['user'])       ? $url['user']      : null;
        $this->pass     = isset($url['pass'])       ? $url['pass']      : null;
        $this->path     = isset($url['path'])       ? $url['path']      : null;
        $this->query    = isset($url['query'])      ? $url['query']     : null;
        $this->fragment = isset($url['fragment'])   ? $url['fragment']  : null;
    }
}
