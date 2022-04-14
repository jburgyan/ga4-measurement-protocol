<?php

declare(strict_types=1);

namespace BluePsyduckTestSerializer\Ga4MeasurementProtocol\Request\Event;

use BluePsyduck\Ga4MeasurementProtocol\Request\Event\JoinGroupEvent;
use BluePsyduckTestSerializer\Ga4MeasurementProtocol\SerializerTestCase;

/**
 * The PHPUnit test of the JoinGroupEvent class.
 *
 * @author BluePsyduck <bluepsyduck@gmx.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPL v3
 * @covers \BluePsyduck\Ga4MeasurementProtocol\Request\Event\JoinGroupEvent
 */
class JoinGroupEventTest extends SerializerTestCase
{
    public function testWithData(): void
    {
        $event = new JoinGroupEvent();
        $event->groupId = 'G_12345';

        $expectedData = [
            'name' => 'join_group',
            'params' => [
                'group_id' => 'G_12345',
            ],
        ];

        $this->assertSerializedObject($expectedData, $event);
    }

    public function testWithoutData(): void
    {
        $event = new JoinGroupEvent();

        $expectedData = [
            'name' => 'join_group',
            'params' => [],
        ];

        $this->assertSerializedObject($expectedData, $event);
    }
}
