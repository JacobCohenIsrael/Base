<?php
namespace JCI\Base\Http\Parameters;

class Headers extends Carrier
{
    const HEADER_TYPE       = 'CONTENT_TYPE';
    const HEADER_LOCATION   = 'LOCATION';
    
    const TYPE_JAVASCRIPT   = 'application/javascript';
    const TYPE_HTML         = 'text/html';
    const TYPE_JSON         = 'application/json';

    /**
     * @return \JCI\Base\Http\Parameters\Headers
     */
    public function send()
    {
        foreach ($this as $key => $value) {
            $key = str_replace('_', '-', $key);
            header("$key: $value");
        }
        return $this;
    }
    
    /**
     * @return string
     */
    public function isJson()
    {
        return strpos($this->getContentType(), '/json') !== false;
    }
    
    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->get(Headers::HEADER_TYPE);
    }
    
    /**
     * @param string $type
     * @return \JCI\Base\Http\Parameters\Headers
     */
    public function setContentType($type)
    {
        return $this->addHeader(Headers::HEADER_TYPE, $type);
    }
    
    /**
     * @param string $to
     * @return \JCI\Base\Http\Parameters\Headers
     */
    public function setRedirect($to)
    {
        return $this->addHeader(Headers::HEADER_LOCATION, $to);
    }
    
    /**
     * @param string $name
     * @param string $value
     * @param bool $replace
     * @return \JCI\Base\Http\Parameters\Headers
     */
    public function addHeader($name, $value, $replace = true)
    {
        // TODO add support to replace false
        $this->set($name, $value);
        return $this;
    }
}