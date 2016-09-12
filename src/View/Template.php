<?php
namespace JCI\Base\View;

use JCI\Base\IO\Exception\IoException;

class Template
{
    /**
     * @var string
     */
    protected $template;
    
    /**
     * @var array
     */
    protected $storage = array();
    
    /**
     * @param string $template
     * @param array $params
     * @throws IoException
     */
    public function __construct($template, array $params = [])
    {
        // TODO: check this type of exception
        if(!file_exists($template))
        {
            throw new IoException("File $template does not exist");
        }
        $this->template = $template;
        
        foreach ($params as $key => $value) {
            $this->__set($key, $value);
        }
    }
    
    /**
     * @param string $index
     * @param mixed $value
     * @return Template
     */
    public function __set($index, $value)
    {
        $this->storage[$index] = $value;
        return $this;
    }
    
    /**
     * @param string $index
     * @return mixed
     */
    public function __get($index)
    {
        return (isset($this->storage[$index])) ? $this->storage[$index] : '';
    }
    
    
    /**
     * @return string
     */
    public function __toString()
    {
        ob_start();
        include $this->template;
        return ob_get_clean();
    }
    
    /**
     * @param mixed $data
     * @return string
     */
    public function json($data)
    {
        return json_encode($data);
    }
}
