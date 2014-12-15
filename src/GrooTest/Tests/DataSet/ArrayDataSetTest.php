<?php

namespace Naldz\GrooTest\Tests\Dataset;

use Naldz\GrooTest\DataSet\ArrayDataSet;

class ArrayDataSetTest extends \PHPUnit_Framework_TestCase
{

    private $arrayDataSet;
    private $data = array(
        'table1' => array(
            array('col1' => 'col1_row1', 'col2' => 'col2_row1'),
            array('col1' => 'col1_row2', 'col2' => 'col2_row2'),
        ),
        'table2' => array(
            array('col1' => 'col1_row1', 'col2' => 'col2_row1'),
            array('col1' => 'col1_row2', 'col2' => 'col2_row2'),
        )
    );

    public function setUp()
    {
        $this->arrayDataSet = new ArrayDataSet($this->data);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetUnkowntableShoudThrowException()
    {
        $this->arrayDataSet->getTable('table3');
    }

    public function testTableData()
    {
        $table1 = $this->arrayDataSet->getTable('table1');
        $this->assertInstanceOf('PHPUnit_Extensions_Database_DataSet_DefaultTable', $table1);
        $this->assertEquals(2, $table1->getRowCount());
        $this->assertEquals('col2_row2', $table1->getValue(1, 'col2'));
    }

}