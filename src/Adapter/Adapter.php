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

namespace Prooph\EventStore\Adapter;

use DateTimeInterface;
use Iterator;
use Prooph\EventStore\Exception\ConcurrencyException;
use Prooph\EventStore\Stream\Stream;
use Prooph\EventStore\Stream\StreamName;
use Prooph\EventStore\Exception\StreamNotFoundException;

/**
 * Interface of an EventStore Adapter
 *
 * @author Alexander Miertsch <contact@prooph.de>
 * @package Prooph\EventStore\Adapter
 */
interface Adapter
{
    public function create(Stream $stream): void;

    /**
     * @throws StreamNotFoundException If stream does not exist
     *
     * @throws ConcurrencyException If two processes are trying to append to the same stream at the same time
     */
    public function appendTo(StreamName $streamName, Iterator $domainEvents): void;

    public function load(StreamName $streamName, int $minVersion = null): ?Stream;

    public function loadEvents(StreamName $streamName, array $metadata = [], int $minVersion = null): Iterator;

    public function replay(StreamName $streamName, DateTimeInterface $since = null, array $metadata = []): Iterator;
}