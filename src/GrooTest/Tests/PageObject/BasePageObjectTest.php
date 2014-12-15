<?php

namespace Naldz\GrooTest\Tests\PageObject;

class BasePageObjectTest extends \PHPUnit_Framework_TestCase
{

    private $basePageObjectStub;

    private function createBaseObjectStub($webDriverMock)
    {
        $stub = $this->getMockForAbstractClass('Naldz\GrooTest\PageObject\BasePageObject', array($webDriverMock));
        $stub->expects($this->any())
             ->method('initialize')
             ->will($this->returnValue(TRUE));

        return $stub;
    }

    private function createWebDriverMock($currentUrl)
    {
        $mock = $this->getMockBuilder('\WebDriver')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('getCurrentUrl')
            ->will($this->returnValue($currentUrl));

        return $mock;
    }

    public function testGetCurrentWebDriverPathReturn()
    {
        $webDriverMock = $this->createWebDriverMock('http://host/path');
        $pabeObjectStub = $this->createBaseObjectStub($webDriverMock);
        $this->assertEquals('/path', $pabeObjectStub->getCurrentWebDriverPath());
    }
}