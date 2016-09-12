<?php
namespace JCI\Base\Http;

class JsonResponse extends Response
{
    /**
     * @return string
     */
    public function __toString()
    {
        // just make sure...
        $this->setJson();
        
        // send HTTP status code
        http_response_code($this->status);
    
        // send headers
        $this->headers->send();
    
        // TODO: cookies
    
        // return data
        return json_encode($this->content);
    }
}
