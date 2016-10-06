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

namespace ProophTest\EventStore\Adapter;

use PHPUnit_Framework_TestCase as TestCase;
use Prooph\EventStore\Adapter\InMemoryAdapter;
use Prooph\EventStore\Exception\StreamNotFoundException;
use Prooph\EventStore\Stream\StreamName;

/**
 * Class InMemoryAdapterTest
 * @package ProophTest\EventStore\Adapter
 */
final class InMemoryAdapterTest extends TestCase
{
    /**
     * @var InMemoryAdapter
     */
    private $adapter;

    protected function setUp(): void
    {
        $this->adapter = new InMemoryAdapter();
    }

    /**
     * @test
     */
    public function it_throws_exception_when_trying_to_append_on_non_existing_stream(): void
    {
        $this->expectException(StreamNotFoundException::class);

        $streamName = $this->prophesize(StreamName::class);
        $streamName->toString()->willReturn('test');

        $this->adapter->appendTo($streamName->reveal(), new \ArrayIterator());
    }

    /**
     * @test
     */
    public function it_returns_nothing_when_trying_to_load_non_existing_stream(): void
    {
        $streamName = $this->prophesize(StreamName::class);
        $streamName->toString()->willReturn('test');

        $this->assertNull($this->adapter->load($streamName->reveal()));
    }

    /**
     * @test
     */
    public function it_returns_nothing_when_trying_to_load_events_by_metadata_fro_omn_non_existing_stream(): void
    {
        $streamName = $this->prophesize(StreamName::class);
        $streamName->toString()->willReturn('test');

        $this->assertEmpty($this->adapter->loadEvents($streamName->reveal(), []));
    }

    /**
     * @test
     */
    public function it_returns_nothing_when_trying_to_replay_non_existing_stream(): void
    {
        $streamName = $this->prophesize(StreamName::class);
        $streamName->toString()->willReturn('test');

        $this->assertCount(0, $this->adapter->replay($streamName->reveal(), null, []));
    }
}