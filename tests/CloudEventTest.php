<?php

declare(strict_types=1);

namespace JustSteveKing\CloudEvents\Tests;

use JustSteveKing\CloudEvents\CloudEvent;
use PHPUnit\Framework\Attributes\Test;

final class CloudEventTest extends PackageTestCase
{
    #[Test]
    public function itCanCreateAnEvent(): void
    {
        $this->assertInstanceOf(
            expected: CloudEvent::class,
            actual: $this->event(),
        );
    }

    #[Test]
    public function itCanCreateAnEventFromAnArray(): void
    {
        $this->assertInstanceOf(
            expected: CloudEvent::class,
            actual: CloudEvent::make(
                data: $this->data(),
            ),
        );
    }

    #[Test]
    public function itCanCastTheObjectToAnArray(): void
    {
        $this->assertIsArray(
            actual: $this->event()->toArray(),
        );
    }
}
