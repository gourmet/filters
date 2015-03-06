<?php

namespace Gourmet\Filters\Test\TestCase\Routing\Filter;

use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;
use Gourmet\Filters\Routing\Filter\RobotsFilter;

class RobotsFilterTest extends TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testConstructor()
    {
        $result = (new RobotsFilter())->config();
    }

    public function testBeforeDispatch()
    {
        $request = new Request(['url' => '/robots.txt']);
        $response = $this->getMock('Cake\Network\Response');
        $event = $this->getMock('Cake\Event\Event', ['stopPropagation'], ['beforeDispatch', null, compact('request', 'response')]);
        $result = (new RobotsFilter())->beforeDispatch($event);
        $this->assertFalse($result instanceof $response);
        $this->assertEquals(200, $result->statusCode());
        $this->assertEquals('text/plain', $result->type());
        $this->assertEquals("User-Agent: *\nDisallow: /", (string)$result);
    }

    public function testAfterDispatch()
    {
        $request = new Request(['url' => '/']);
        $response = $this->getMock('Cake\Network\Response');
        $response->expects($this->once())
            ->method('header')
            ->with('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $event = new Event('beforeDispatch', null, compact('request', 'response'));
        $result = (new RobotsFilter())->afterDispatch($event);
    }
}
