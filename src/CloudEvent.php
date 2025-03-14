<?php

declare(strict_types=1);

namespace JustSteveKing\CloudEvents;

use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see https://cloudevents.io/
 */
final class CloudEvent
{
    public const string SPEC_VERSION = '1.0';

    /**
     * @param string $id Identifies the event. Producers MUST ensure that source + id is unique for each distinct event. If a duplicate event is re-sent (e.g. due to a network error) it MAY have the same id. Consumers MAY assume that Events with identical source and id are duplicates.
     * @param string $source Identifies the context in which an event happened. Often this will include information such as the type of the event source, the organization publishing the event or the process that produced the event. The exact syntax and semantics behind the data encoded in the URI is defined by the event producer.
     * @param string $type This attribute contains a value describing the type of event related to the originating occurrence. Often this attribute is used for routing, observability, policy enforcement, etc. The format of this is producer defined and might include information such as the version of the type
     * @param mixed $data The data you want to send in the cloud event.
     * @param string|null $dataContentType Content type of data value. This attribute enables data to carry any type of content, whereby format and encoding might differ from that of the chosen event format. For example, an event rendered using the JSON envelope format might carry an XML payload in data, and the consumer is informed by this attribute being set to "application/xml". The rules for how data content is rendered for different datacontenttype values are defined in the event format specifications; for example, the JSON event format defines the relationship in section 3.1.
     * @param string|null $dataSchema Identifies the schema that data adheres to. Incompatible changes to the schema SHOULD be reflected by a different URI. See Versioning of CloudEvents in the Primer for more information.
     * @param string|null $subject This describes the subject of the event in the context of the event producer (identified by source). In publish-subscribe scenarios, a subscriber will typically subscribe to events emitted by a source, but the source identifier alone might not be sufficient as a qualifier for any specific event if the source context has internal sub-structure.
     * @param DateTimeInterface|null $time Timestamp of when the occurrence happened. If the time of the occurrence cannot be determined then this attribute MAY be set to some other time (such as the current time) by the CloudEvents producer, however all producers for the same source MUST be consistent in this respect. In other words, either they all use the actual time of the occurrence or they all use the same algorithm to determine the value used.
     */
    public function __construct(
        public string $id,
        public string $source,
        public string $type,
        public mixed $data,
        public string|null $dataContentType = null,
        public string|null $dataSchema = null,
        public string|null $subject = null,
        public DateTimeInterface|null $time = null,
    ) {}

    /**
     * Create a Cloud Event from an array
     *
     * @param array{
     *     id:string,
     *     source:string,
     *     type:string,
     *     data:mixed,
     *     data_content_type:null|string,
     *     data_schema:null|string,
     *     subject:null|string,
     *     time:null|string,
     * } $data
     * @return CloudEvent
     * @throws DateMalformedStringException
     */
    public static function make(array $data): CloudEvent
    {
        return new CloudEvent(
            id: $data['id'],
            source: $data['source'],
            type: $data['type'],
            data: $data['data'],
            dataContentType: $data['data_content_type'] ?? null,
            dataSchema: $data['data_schema'] ?? null,
            subject: $data['subject'] ?? null,
            time: $data['time'] ? new DateTimeImmutable(
                datetime: $data['time'],
            ) : null,
        );
    }

    /**
     * Turn the Cloud Event into an array.
     *
     * @return array{
     *     specversion:string,
     *     type:string,
     *     source:string,
     *     subject:null|string,
     *     id:string,
     *     time:null|string,
     *     datacontenttype:null|string,
     *     dataschema:null|string,
     *     data:mixed,
     * }
     */
    public function toArray(): array
    {
        return [
            'specversion' => self::SPEC_VERSION,
            'type' => $this->type,
            'source' => $this->source,
            'subject' => $this->subject,
            'id' => $this->id,
            'time' => $this->time?->format(
                format: DateTimeInterface::RFC3339,
            ),
            'datacontenttype' => $this->dataContentType,
            'dataschema' => $this->dataSchema,
            'data' => $this->data,
        ];
    }
}
