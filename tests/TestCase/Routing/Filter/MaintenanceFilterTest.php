<?php

namespace Gourmet\Filters\Test\TestCase\Routing\Filter;

use Cake\Event\Event;
use Cake\TestSuite\TestCase;
use Gourmet\Filters\Routing\Filter\MaintenanceFilter;

class MaintenanceFilterTest extends TestCase
{
    protected $_maintenanceFilePath;

    public function setUp()
    {
        $this->_maintenanceFilePath = ROOT . DS . 'maintenance.html';
    }

    public function tearDown()
    {
        parent::tearDown();
        if (file_exists($this->_maintenanceFilePath)) {
            unlink($this->_maintenanceFilePath);
        }
    }

    public function testConstructor()
    {
        $result = (new MaintenanceFilter())->config();
        $this->assertEquals(1, $result['priority']);
        $this->assertEquals($this->_maintenanceFilePath, $result['path']);
        $this->assertFalse($result['when']());
        touch($this->_maintenanceFilePath);
        $this->assertTrue($result['when']());

        $result = (new MaintenanceFilter(['path' => '/foo/bar.html']))->config();
        $this->assertEquals('/foo/bar.html', $result['path']);
    }

    public function testBeforeDispatch()
    {
        touch($this->_maintenanceFilePath);
        $result = (new MaintenanceFilter())->beforeDispatch(new Event('beforeDispatch'));
        $this->assertInstanceOf('Cake\Network\Response', $result);
        $this->assertEquals(503, $result->statusCode());
    }
}
