<?php

namespace Naldz\GrooTest\Tests\Config;

use Naldz\GrooTest\Config\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    protected $configData = array('a' => 'a_val', 'b' => 'b_val');

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetWithInvalidKey()
    {
        $configuration = new Configuration($this->configData);

        $configuration->get('c');
    }

    public function testGetWithValidKey(){
        $configuration = new Configuration($this->configData);

        $this->assertEquals($configuration->get('a'), 'a_val');
    }

    public function testIsConfigKeyExistsReturnsTrueIfKeyExists()
    {
        $configuration = new Configuration($this->configData);

        $this->assertTrue($configuration->isConfigKeyExists('a'));
    }

    public function testIsConfigKeyExistsReturnsFalseIfKeyDoNotExists()
    {
        $configuration = new Configuration($this->configData);

        $this->assertFalse($configuration->isConfigKeyExists('c'));
    }
}