<?php
/**
 * This file is part of the prooph/event-store.
 * (c) 2014-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ProophTest\EventStore\Adapter\PayloadSerializer;

use Prooph\EventStore\Adapter\PayloadSerializer\JsonPayloadSerializer;
use ProophTest\EventStore\TestCase;

/**
 * Class JsonPayloadSerializerTest
 * @package ProophTest\EventStore\Adapter\PayloadSerializer
 */
final class JsonPayloadSerializerTest extends TestCase
{
    /**
     * @test
     * @dataProvider providePayload
     */
    public function it_serializes_and_unserializes_a_payload_array(array $payload): void
    {
        $serializer = new JsonPayloadSerializer();

        $payloadStr = $serializer->serializePayload($payload);

        $payloadCopy = $serializer->unserializePayload($payloadStr);

        $this->assertEquals($payload, $payloadCopy);
    }

    public function providePayload(): array
    {
        return [
            [
                ['string' => 'payload'],
                ['bool_true' => true, 'bool_false' => false],
                ['int' => 1234],
                ['float' => 10.2],
                ['null' => null],
                ['array' => ['nested' => ['data' => 'structure']]],
            ]
        ];
    }
}