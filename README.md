README
======

What is GrooTest
----------------

GrooTest is collection of libraries primarily used for functional testing. It provides
base classes for database tests, web tests and page objects. It also provides fixture 
management for tests.

Requirements
------------

- GrooTest is only supported on PHP 5.3 and up.
- PHPUnit 3.7 and uip
- PHPUnit DBUnit Extension

Installation
------------

composer require naldz/GrooTest


Configuration
-------------

GrooTest reads configuration data from the $_ENV variable. A prefix variable in which GrooTest
will based the name of the configuration variables should be provided. The best way to defined these
environment variables is through a phpunit.xml config file.

Example:

```
<php>
        <env name="GROOTEST_CONFIG_PREFIX" value="TEST_CONFIG_" />
        <env name="TEST_CONFIG_SELENIUM_HOST" value="http://localhost:4444/wd/hub" />
        <env name="TEST_CONFIG_DSN" value="sqlite:/path/db.sqlite" />
</php>

```

With the configuration example above, GrooTest will use the 'TEST_CONFIG_' text as a prefix for all 
test configuration data. The 'TEST_CONFIG_SELENIUM_HOST' environment variable will be read and saved as
SELENIUM_HOST config data with a value of 'http://localhost:4444/wd/hub' and the TEST_CONFIG_DSN as 
DSN with value of 'sqlite:/path/db.sqlite'. The configuration data now looks like this:

```
array(
    "SELENIUM_HOST" => "http://localhost:4444/wd/hub",
    "DSN" => "sqlite:/path/db.sqlite"
)
```

This configuration map is saved into a Configuration object (Naldz\GrooTest\Config\Configuration) which 
is a protected property (config) of the WebTestCase class.

It is also important to instantiate the Configuration object on the bootrap file and assign it to the 
"GROOTEST_CONFIG" environment variable.

```
use Naldz\GrooTest\Config\ConfigurationManager;
use Naldz\GrooTest\Config\Configuration;

$configManager = new ConfigurationManager();
$configData = $configManager->getConfigurationData();
$_ENV['GROOTEST_CONFIG'] = new Configuration($configData);
```

Test Cases
----------

It is always a good idea to create a TestCase class that will serve as a base test case of your project. 
This TestCase class should extend from the WebTestCase (Naldz\GrooTest\Tests\TestCase\WebTestCase) class 
which is a subclass of the DatabaseTestCase (Naldz\GrooTest\Tests\TestCase\DatabaseTestCase) class. The
DatabaseTestCase is also a subclass of the PHPUnit_Extensions_Database_TestCase which is an abstract
class provided by the DBUnit PHPUnit extension. The hierarchy of classes is illustrated below:


```
PHPUnit_Extensions_Database_TestCase
  |
  |
  -- DatabaseTestCase \\ Responsible for fixture loading
       |
       |
       -- WebTestCase \\ Responsible for defining objects related to Selenium
            |
            | 
            -- ProjectTestCase \\ Should implement the abstract method 'getConnection' and definition of fixture sets
```