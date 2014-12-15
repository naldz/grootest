<?php

namespace Naldz\GrooTest\Tests\TestCase;

class DatabaseTestCaseTest extends \PHPUnit_Framework_TestCase
{

    private $fixturePath;

    public function setUp()
    {
        parent::setUp();
        $this->fixturePath = $_ENV['FIXTURE_PATH'];
    }

    private function createDatabaseTestCaseStub($currentMethod)
    {
        $stub = $this->getMockBuilder('Naldz\GrooTest\TestCase\DatabaseTestCase')
             ->disableOriginalConstructor()
             ->setMethods(array('getName'))
             ->getMockForAbstractClass();

        $stub->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($currentMethod));

        return $stub;
    }

    public function testUndefinedMethodInFixtureMapShouldReturnDefaultDataSet()
    {

        $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
        $dbTestCaseStub->setFixtureMap(array('testMethod2' => array('fixture1')));

        $dataSet = $dbTestCaseStub->getDataset();

        $this->assertInstanceOf('PHPUnit_Extensions_Database_DataSet_DefaultDataSet', $dataSet);
    }

    public function testDefinedMethodInFixtureMapShoulReturnCompositDataSet()
    {
        $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
        $dbTestCaseStub->setFixtureMap(array('testMethod1' => array($this->fixturePath.'/fixture1.yml')));

        $dataSet = $dbTestCaseStub->getDataset();
    }

    public function testFixtureDefinedAsArray()
    {
        $dbTestCaseStub = $this->createDatabaseTestCaseStub('testMethod1');
        $dbTestCaseStub->setFixtureMap(array(
            'testMethod1' => array(
                array(
                    'table1' => array(
                        array('col1' => 'col1_row1', 'col2' => 'col2_row1'),
                        array('col1' => 'col1_row2', 'col2' => 'col2_row2'),
                    ),
                )
            )
        ));

        $dataSet = $dbTestCaseStub->getDataset();
        $this->assertEquals(array('table1'), $dataSet->getTableNames());
        $this->assertEquals(2, $dataSet->getTable('table1')->getRowCount());

    }
}