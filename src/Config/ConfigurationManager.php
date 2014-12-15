<?php

namespace Naldz\GrooTest\Config;

use Naldz\GrooTest\Config\Configuration;

class ConfigurationManager
{
    private $configPrefix;

    public function getConfigurationData()
    {
        //get all the environment variables starting with 'TEST_CONFIG'
        if (!isset($_ENV['GROOTEST_CONFIG_PREFIX']) || !strlen($_ENV['GROOTEST_CONFIG_PREFIX'])) {
            throw new \Exception('Environment variable "GROOTEST_CONFIG_PREFIX" is not defined or is empty!');
        }

        $this->configPrefix = $_ENV['GROOTEST_CONFIG_PREFIX'];

        $configData = array();

        $configPrefixLength = strlen($this->configPrefix);
        foreach ($_ENV as $key => $value) {
            if (substr($key, 0, $configPrefixLength) == $this->configPrefix) {
                $configData[str_replace($this->configPrefix, '', $key)] = $value;
            }
        }

        return $configData;

    }
}