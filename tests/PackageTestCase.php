<?php

declare(strict_types=1);

namespace JustSteveKing\CloudEvents\Tests;

use DateMalformedStringException;
use JsonException;
use JustSteveKing\CloudEvents\CloudEvent;
use PHPUnit\Framework\TestCase;

abstract class PackageTestCase extends TestCase
{
    /**
     * Return the Cloud Event instance.
     *
     * @return CloudEvent
     * @throws JsonException|DateMalformedStringException
     */
    protected function event(): CloudEvent
    {
        return CloudEvent::make($this->data());
    }

    /**
     * Return the data for the Cloud Event.
     *
     * @return array
     * @throws JsonException
     */
    protected function data(): array
    {
        return [
            'id' => '1234',
            'source' => '/some-url',
            'type' => 'com.vendor.action.event',
            'data' => json_encode(['foo' => 'bar'], JSON_THROW_ON_ERROR),
            'data_content_type' => 'application/json',
            'data_schema' => null,
            'subject' => 'cloud-event.json',
            'time' => '01/01/1234',
        ];
    }
}
