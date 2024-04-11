<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Service\Clock;

use Psr\Clock\ClockInterface;

final class SystemClock implements ClockInterface
{
    public function __construct(private readonly \DateTimeZone $timezone) {}

    public static function fromUTC(): self
    {
        return new self(new \DateTimeZone('UTC'));
    }

    public function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', $this->timezone);
    }
}
