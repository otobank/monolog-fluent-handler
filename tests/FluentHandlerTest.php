<?php

namespace Otobank\Monolog\Handler\Tests;

use Monolog\Logger;
use Otobank\Monolog\Handler\FluentHandler;
use ReflectionClass;

class FluentHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider uriProvider
     */
    public function testParseUri($uri, $instanceOf, $host, $port)
    {
        try {
            $logger = $this->getProperty(new FluentHandler($uri), 'logger');
            $this->assertInstanceOf($instanceOf, $logger);
            $this->assertAttributeEquals($host, 'host', $logger);
            $this->assertAttributeEquals($port, 'port', $logger);
        } catch (\InvalidArgumentException $e) {
            $this->markTestSkipped('Bug #66813 Detect some valid url as invalid in parse_url. (fixed in 5.5.24 and 5.6.8)');
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidUri()
    {
        new FluentHandler('invalid://yes');
    }

    /**
     * @dataProvider recordProvider
     */
    public function testWrite(array $record, $tag, array $data)
    {
        $logger = $this->getMockBuilder('Fluent\Logger\FluentLogger')
            ->disableOriginalConstructor()
            ->getMock();

        $logger
            ->expects($this->once())
            ->method('post')
            ->with($tag, $data)
        ;

        $handler = new FluentHandler($logger);
        $handler->write($record);
    }

    public function uriProvider()
    {
        return [
            ['http://192.0.2.1:1234/', 'Fluent\\Logger\\HttpLogger', '192.0.2.1', 1234],
            ['tcp://192.0.2.2:3456/', 'Fluent\\Logger\\FluentLogger', '192.0.2.2', 3456],
            ['//192.0.2.3:946?socket_timeout=5', 'Fluent\\Logger\\FluentLogger', '192.0.2.3', 946],
        ];
    }

    public function recordProvider()
    {
        return [
            [
                [
                    'channel' => 'unittest',
                    'message' => 'This is it.',
                    'context' => [],
                    'formatted' => 'This is formatted.',
                    'level' => Logger::DEBUG,
                ],
                'unittest',
                [
                    'message' => 'This is it.',
                    'level' => Logger::getLevelName(Logger::DEBUG),
                ]
            ],
            [
                [
                    'channel' => 'unittest',
                    'message' => 'This is it.',
                    'context' => [
                        'Here' => 'Comes the sun.',
                    ],
                    'formatted' => 'This is formatted.',
                    'level' => Logger::DEBUG,
                ],
                'unittest',
                [
                    'Here' => 'Comes the sun.',
                    'message' => 'This is it.',
                    'level' => Logger::getLevelName(Logger::DEBUG),
                ]
            ],
        ];
    }

    private function getProperty($obj, $property)
    {
        $reflectionClass = new ReflectionClass($obj);
        $loggerProperty = $reflectionClass->getProperty($property);
        $loggerProperty->setAccessible(true);

        return $loggerProperty->getValue($obj);
    }
}
