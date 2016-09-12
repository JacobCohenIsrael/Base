<?php
namespace JCI\Base\Http\Parameters;

class Server extends Carrier
{
    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        foreach ($this as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            }
        }
        foreach (['CONTENT_LENGTH', 'CONTENT_MD5', 'CONTENT_TYPE'] as $key) {
            if (isset($this[$key])) {
                $headers[$key] = $this[$key];
            }
        }
        return $headers;
    }
    /**
     * @return string
     */
    public function getRemoteAddr()
    {
        return $this->get('REMOTE_ADDR');
    }
    /**
     * @return string
     */
    public function getHost()
    {
        return $this->get('HTTP_HOST');
    }
    
    /**
     * @return string
     */
    public function getUri()
    {
        return $this->get('REQUEST_URI');
    }
    
    /**
     * @return string
     */
    public function getAccept()
    {
        return $this->get('HTTP_ACCEPT');
    }
    
    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->get('QUERY_STRING');
    }
            
    /**
     * @return boolean
     */
    public function isHttps()
    {
        return 'on' == $this->get('HTTPS', 'off');
    }
    
    /**
     * @deprecated
     * @return boolean
     */
    public function isJson()
    {
        return strpos($this->getAccept(), '/json') !== false;
    }
    
    /**
     * @return string
     */
    public function getServerAddr()
    {
        return $this->get('SERVER_ADDR');
    }
}