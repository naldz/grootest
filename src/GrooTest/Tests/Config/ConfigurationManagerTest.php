<?php

namespace Naldz\GrooTest\Tests\Config;

use Naldz\GrooTest\Config\ConfigurationManager;

class ConfigurationManagerTest extends \PHPUnit_Framework_TestCase
{

    private $configurationManager;

    public function setUp()
    {
        $this->configurationManager = new ConfigurationManager();
    }

    /**
     * @expectedException Exception
     */
    public function testGetConfigurationDataWithNoPrefixShouldThrowException()
    {
        $this->configurationManager->getConfigurationData();
    }

    public function testConfigurationDataMapping()
    {
        $_ENV['GROOTEST_CONFIG_PREFIX'] = 'xxx_';
        $_ENV['xxx_a'] = 'a';
        $_ENV['xxx_b'] = 'b';

        $exceptedConfigData = array(
            'a' => 'a',
            'b' => 'b'
        );

        $this->assertEquals($exceptedConfigData, $this->configurationManager->getConfigurationData());
    }

}