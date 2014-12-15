<?php

namespace Naldz\GrooTest\Tests\TestCase;

class WebTestCaseTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        unset($_ENV['GROOTEST_CONFIG']);
    }

    private function createWebTestCaseStub()
    {
        $stub = $this->getMockBuilder('Naldz\GrooTest\TestCase\WebTestCase')
             ->disableOriginalConstructor()
             ->getMockForAbstractClass();

        //PHPUnit_Extensions_Database_TestCase requires the 'getConnection' method to return
        //an instance of PHPUnit_Extensions_Database_DB_IDatabaseConnection
        $stub->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue(
                $this->getMock('\PHPUnit_Extensions_Database_DB_IDatabaseConnection')
            ));
        return $stub;
    }

    private function createConfigMock($configData)
    {
        $configMock = $this->getMockBuilder('Naldz\GrooTest\Config\Configuration')
            ->disableOriginalConstructor()
            ->getMock();

        $configMock->expects($this->any())
            ->method('isConfigKeyExists')
            ->will($this->returnCallback(function($key) use ($configData) {
                return array_key_exists($key, $configData);
            }));

        $configMock->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function($key) use ($configData) {
                if (!array_key_exists($key, $configData)) {
                    throw new \InvalidArgumentException('Invalid key '.$key);
                }
                return $configData[$key];
            }));

        return $configMock;
    }

    public function testSetUp()
    {
        $_ENV['GROOTEST_CONFIG'] = $this->createConfigMock(array(
            'WEBDRIVER_BROWSER_NAME' => 'firefox',
            'SELENIUM_HOST' => 'seleniumhost.com'
        ));

        $class = $this->getMockClass(
            '\RemoteWebDriver',
            array('create')
        );

        $class::staticExpects($this->once())
              ->method('create')
              ->with('seleniumhost.com', array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox'), 5000)
              ->will($this->returnValue(null));
 
        $webTestCase = $this->createWebTestCaseStub();
        $webTestCase->setWebDriverClass($class);
        $webTestCase->setUp();
    }


    
    // public function testUndefinedMethodInFixtureMapShouldReturnDefaultDataSet()
    // {

    //     $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
    //     $dbTestCaseStub->setFixtureMap(array('testMethod2' => array('fixture1')));

    //     $dataSet = $dbTestCaseStub->getDataset();

    //     $this->assertInstanceOf('PHPUnit_Extensions_Database_DataSet_DefaultDataSet', $dataSet);
    // }

    // public function testDefinedMethodInFixtureMapShoulReturnCompositDataSet()
    // {
    //     $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
    //     $dbTestCaseStub->setFixtureMap(array('testMethod1' => array($this->fixturePath.'/fixture1.yml')));

    //     $dataSet = $dbTestCaseStub->getDataset();
    // }

    // public function testFixtureDefinedAsArray()
    // {
    //     $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
    //     $dbTestCaseStub->setFixtureMap(array(
    //         'testMethod1' => array(
    //             array(
    //                 'table1' => array(
    //                     array('col1' => 'col1_row1', 'col2' => 'col2_row1'),
    //                     array('col1' => 'col1_row2', 'col2' => 'col2_row2'),
    //                 ),
    //             )
    //         )
    //     ));

    //     $dataSet = $dbTestCaseStub->getDataset();
    //     $this->assertEquals(array('table1'), $dataSet->getTableNames());
    //     $this->assertEquals(2, $dataSet->getTable('table1')->getRowCount());

    // }
}