<?php

namespace Naldz\GrooTest\TestCase;

use Naldz\GrooTest\TestCase\DatabaseTestCase;

abstract class WebTestCase extends DatabaseTestCase
{

    protected $webDriver;
    protected $config;
    protected $webDriverClass = '\RemoteWebDriver';

    public function setWebDriverClass($webDriverClass)
    {
        $this->webDriverClass = $webDriverClass;
    }

    public function setUp()
    {
        $this->config = $_ENV['GROOTEST_CONFIG'];

        $webDriverConfigKeys = array(
            'WEBDRIVER_BROWSER_NAME'                => \WebDriverCapabilityType::BROWSER_NAME,
            'WEBDRIVER_VERSION'                     => \WebDriverCapabilityType::VERSION,
            'WEBDRIVER_PLATFORM'                    => \WebDriverCapabilityType::PLATFORM,
            'WEBDRIVER_JAVASCRIPT_ENABLED'          => \WebDriverCapabilityType::JAVASCRIPT_ENABLED,
            'WEBDRIVER_TAKES_SCREENSHOT'            => \WebDriverCapabilityType::TAKES_SCREENSHOT,
            'WEBDRIVER_HANDLES_ALERTS'              => \WebDriverCapabilityType::HANDLES_ALERTS,
            'WEBDRIVER_DATABASE_ENABLED'            => \WebDriverCapabilityType::DATABASE_ENABLED,
            'WEBDRIVER_LOCATION_CONTEXT_ENABLED'    => \WebDriverCapabilityType::LOCATION_CONTEXT_ENABLED,
            'WEBDRIVER_APPLICATION_CACHE_ENABLED'   => \WebDriverCapabilityType::APPLICATION_CACHE_ENABLED,
            'WEBDRIVER_BROWSER_CONNECTION_ENABLED'  => \WebDriverCapabilityType::BROWSER_CONNECTION_ENABLED,
            'WEBDRIVER_CSS_SELECTORS_ENABLED'       => \WebDriverCapabilityType::CSS_SELECTORS_ENABLED,
            'WEBDRIVER_WEB_STORAGE_ENABLED'         => \WebDriverCapabilityType::WEB_STORAGE_ENABLED,
            'WEBDRIVER_ROTATABLE'                   => \WebDriverCapabilityType::ROTATABLE,
            'WEBDRIVER_ACCEPT_SSL_CERTS'            => \WebDriverCapabilityType::ACCEPT_SSL_CERTS,
            'WEBDRIVER_NATIVE_EVENTS'               => \WebDriverCapabilityType::NATIVE_EVENTS,
            'WEBDRIVER_PROXY'                       => \WebDriverCapabilityType::PROXY
        );

        $capabilities = array();
        foreach ($webDriverConfigKeys as $configKey => $capabilityType) {
            if ($this->config->isConfigKeyExists($configKey)) {
                $capabilities[$capabilityType] = $this->config->get($configKey);
            }
        }
        $webDriverClass = $this->webDriverClass;

        $this->webDriver = $webDriverClass::create($this->config->get('SELENIUM_HOST'), $capabilities, 5000);

        parent::setUp();
    }

    public function tearDown()
    {
        if ($this->webDriver) {
            $this->webDriver->quit();
        }

        parent::tearDown();
    }


}