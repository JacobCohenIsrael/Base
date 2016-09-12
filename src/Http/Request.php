<?php
namespace JCI\Base\Http;

use JCI\Base\Application\Contracts\Request as RequestContract;
use JCI\Base\Http\HttpSession;
use JCI\Base\Application\Contracts\Application;
use JCI\Base\Config\ArrayConfig;
use JCI\Base\Http\Parameters\Server;
use JCI\Base\Http\Parameters\Headers;
use JCI\Base\Http\Parameters\Carrier;
use JCI\Base\Http\Parameters\Files;

class Request implements RequestContract 
{
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $query;
    
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $post;
    
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $cookies;
    
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $gpc;
    
    /**
     * @var \JCI\Base\Http\Parameters\Server
     */
    public $server;
    
    /**
     * @var \JCI\Base\Http\Parameters\Headers
     */
    public $headers;
    
    /**
     * @var \JCI\Base\Http\Parameters\Files
     */
    public $files;
    
    /**
     * @var \JCI\Base\Http\Parameters\Carrier
     */
    public $attributes;
    
    /**
     * @var \JCI\Base\Http\HttpUri
     */
    public $uri;
    
    /**
     * @var string
     */
    protected $body;
    
    /**
     * @param Carrier $query
     * @param Carrier $post
     * @param Carrier $cookies
     * @param Carrier $gpc
     * @param Server $server
     * @param Carrier $attributes
     */
    public function __construct(Carrier $query, Carrier $post, Carrier $cookies, Carrier $gpc, Server $server, Files $files, Carrier $attributes = null)
    {
        $this->query        = $query;
        $this->post         = $post;
        $this->cookies      = $cookies;
        $this->gpc          = $gpc;
        $this->server       = $server;
        $this->headers      = new Headers($server->getHeaders());
        $this->files        = $files;
        $this->attributes   = $attributes ?: new Carrier();
        $this->uri          = HttpUri::createFromServer($server);
    
        // support JSON type request
        if ($this->headers->isJson()) {
            $data = json_decode($this->getBody(), true);
            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    $gpc->set($k, $v);
                    $post->set($k, $v);
                }
            }
        }
    }
    
    /**
     * @return \JCI\Base\Http\Request
     */
    static public function create()
    {
        return new static(
            new Carrier($_GET),
            new Carrier($_POST),
            new Carrier($_COOKIE),
            new Carrier($_REQUEST),
            new Server($_SERVER),
            new Files($_FILES)
        );
    }
    
    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD', 'GET');
    }
    
    /**
     * @return string
     */
    public function getBody()
    {
        if (empty($this->body)) {
            $body = file_get_contents('php://input');
            if (false !== $body) {
                $this->body = $body;
            }
        }
        return $this->body;
    }
    
    /**
     * @param string $body
     * @return \JCI\Base\Http\Request
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    /**
     * @return \JCI\Base\Http\HttpApplication
     */
    public function getApp()
    {
        return $this->attributes->get(HttpKeys::APP);
    }
    
    /**
     * @return string
     */
    public function getController()
    {
        return $this->attributes->get(HttpKeys::CONTROLLER);
    }
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->attributes->get(HttpKeys::ACTION);
    }
    
    /**
     * @return array
     */
    public function getActionArguments()
    {
        return $this->attributes->get(HttpKeys::ACTIONARGUMENTS);
    }
    
    /**
     * @return \JCI\Base\Http\HttpSession
     */
    public function getSession()
    {
        if (!$this->attributes->has(HttpKeys::SESSION)) {
            $this->setSession(new HttpSession());
        }
        return $this->attributes->get(HttpKeys::SESSION);
    }
    
    /**
     * @param HttpApplication $app
     * @return \JCI\Base\Http\Request
     */
    public function setApp(Application $app)
    {
        $this->attributes->set(HttpKeys::APP, $app);
        return $this;
    }
    
    /**
     * @param string $controller
     * @return \JCI\Base\Http\Request
     */
    public function setController($name)
    {
        $this->attributes->set(HttpKeys::CONTROLLER, $name);
        return $this;
    }
    
    /**
     * @param string $name
     * @return \JCI\Base\Http\Request
     */
    public function setAction($name)
    {
        $this->attributes->set(HttpKeys::ACTION, $name);
        return $this;
    }
    
    /**
     * @param ArrayConfig $arguments
     * @return \JCI\Base\Http\Request
     */
    public function setActionArguments(ArrayConfig $arguments)
    {
        $this->attributes->set(HttpKeys::ACTIONARGUMENTS, $arguments);
        return $this;
    }
    
    /**
     * @param HttpSession $session
     * @return \JCI\Base\Http\Request
     */
    public function setSession(HttpSession $session)
    {
        $this->attributes->set(HttpKeys::SESSION, $session);
        return $this;
    }
}