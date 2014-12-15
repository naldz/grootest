<?php

namespace Naldz\GrooTest\TestCase;

use Naldz\GrooTest\DataSet\ArrayDataSet;

abstract class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    protected $fixtureMap = array();

    public function setFixtureMap($fixtureMap)
    {
        $this->fixtureMap = $fixtureMap;
    }

    public function getFixtureMap()
    {
        return $this->fixtureMap;
    }

    public function getDataSet()
    {
        $fixtures = array();
        if (isset($this->fixtureMap[$this->getName()])) {
            $fixtures = $this->fixtureMap[$this->getName()];
        }

        if (count($fixtures)) {
            $datasets = array();

            foreach ($fixtures as $iFixture) {
                if (is_array($iFixture)) {
                    $datasets[] = new ArrayDataSet($iFixture);
                }
                else {

                    $datasets[] = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                        $this->getFullFixturePath($iFixture)
                    );
                }
            }
            $compositeDs = new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);
            return $compositeDs;
        }
        
        //return a default dataset
        return new \PHPUnit_Extensions_Database_DataSet_DefaultDataSet();
    }


    protected function getFullFixturePath($fixture)
    {
        return $fixture;
    }

}