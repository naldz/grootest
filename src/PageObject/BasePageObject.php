<?php

namespace Naldz\GrooTest\PageObject;

use \WebDriver;

abstract class BasePageObject
{    
    protected $webDriver;

    public function __construct(WebDriver $webDriver)
    {
        $this->webDriver = $webDriver;
        $this->initialize();
    }

    abstract protected function initialize();

    public function getCurrentWebDriverPath()
    {
        $urlComponents = parse_url($this->webDriver->getCurrentUrl());

        if ($urlComponents !== false) {
            return $urlComponents['path'];
        }

        return null;
    }

}