<?php

namespace Naldz\GrooTest\Config;

use Symfony\Component\Yaml\Parser;

class Configuration
{
    
    protected $config = array();

    public function __construct($config = array())
    {
        $this->config = $config;
    }
    
    public function get($key)
    {
        if ($this->isConfigKeyExists($key)) {
            return $this->config[$key];
        }
        throw new \InvalidArgumentException(sprintf('Configuration key \'%s\' does not exists.', $key));
    }
    
    public function isConfigKeyExists($key)
    {
        return isset($this->config[$key]);
    }
}