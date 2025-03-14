# Cloud Events PHP

[![CI](https://github.com/JustSteveKing/cloudevents/actions/workflows/ci.yml/badge.svg)](https://github.com/JustSteveKing/cloudevents/actions/workflows/ci.yml)

Welcome to the **Cloud Events PHP** repository! This library enables you to create and manage [Cloud Events](https://cloudevents.io/) in PHP with ease.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Properties](#properties)
- [Why Cloud Events?](#why-cloud-events)
- [Examples](#examples)
  - [Distributed Systems Communication](#distributed-systems-communication)
  - [Audit Trail & Logging](#audit-trail--logging)
  - [Integration Scenarios](#integration-scenarios)
  - [Common Use Cases](#common-use-cases)
  - [Example 1: User Registration Event](#example-1-user-registration-event)
  - [Example 2: Order Created Event](#example-2-order-created-event)
  - [Example 3: File Upload Event](#example-3-file-upload-event)
- [Contributing](#contributing)
- [License](#license)

## Installation

Install the library via Composer:

```bash
composer require juststeveking/cloudevents
```

## Usage

Here's a basic example of how to create a Cloud Event:

```php
use JustSteveKing\CloudEvents\CloudEvent;

$event = new CloudEvent(
    id => '1234',
    source => '/some-url',
    type => 'com.vendor.action.event',
    data => json_encode(['foo' => 'bar'], JSON_THROW_ON_ERROR),
    dataContentType => 'application/json',
    data_schema => null,
    subject => 'cloud-event.json',
    time => '01/01/1234',
);
```

You can also pass through an array to the static `make` method:

```php
use JustSteveKing\CloudEvents\CloudEvent;

$event = CloudEvent::make([
    'id' => '1234',
    'source' => '/some-url',
    'type' => 'com.vendor.action.event',
    'data' => json_encode(['foo' => 'bar'], JSON_THROW_ON_ERROR),
    'data_content_type' => 'application/json',
    'dataSchema' => null,
    'subject' => 'cloud-event.json',
    'time' => '01/01/1234',
]);
```

## Features

- Easy creation and management of Cloud Events
- Flexible event data structure


## Properties

- `id`: Identifies the event. Producers MUST ensure that source + id is unique for each distinct event. If a duplicate event is re-sent (e.g. due to a network error) it MAY have the same id. Consumers MAY assume that Events with identical source and id are duplicates.
- `source`: Identifies the context in which an event happened. Often this will include information such as the type of the event source, the organization publishing the event or the process that produced the event. The exact syntax and semantics behind the data encoded in the URI is defined by the event producer.
- `type`: This attribute contains a value describing the type of event related to the originating occurrence. Often this attribute is used for routing, observability, policy enforcement, etc. The format of this is producer defined and might include information such as the version of the type.
- `data`: The data you want to send in the cloud event.
- `dataContentType`: Content type of data value. This attribute enables data to carry any type of content, whereby format and encoding might differ from that of the chosen event format. For example, an event rendered using the JSON envelope format might carry an XML payload in data, and the consumer is informed by this attribute being set to "application/xml". The rules for how data content is rendered for different datacontenttype values are defined in the event format specifications; for example, the JSON event format defines the relationship in section 3.1.
- `dataSchema`: Identifies the schema that data adheres to. Incompatible changes to the schema SHOULD be reflected by a different URI. See Versioning of CloudEvents in the Primer for more information.
- `subject`: This describes the subject of the event in the context of the event producer (identified by source). In publish-subscribe scenarios, a subscriber will typically subscribe to events emitted by a source, but the source identifier alone might not be sufficient as a qualifier for any specific event if the source context has internal sub-structure.
- `time`: Timestamp of when the occurrence happened. If the time of the occurrence cannot be determined then this attribute MAY be set to some other time (such as the current time) by the CloudEvents producer, however all producers for the same source MUST be consistent in this respect. In other words, either they all use the actual time of the occurrence or they all use the same algorithm to determine the value used.


## Why Cloud Events?

CloudEvents is a specification for describing event data in a common way. This allows for interoperability between services and systems that produce and consume events. The specification is designed to be language agnostic and is supported by a wide range of programming languages and frameworks. This is the PHP implementation that makes sense to me.

## Examples

Here are some examples of how you could use this library to create Cloud Events. When are cloud events are useful? They're standardized ways to describe events in any cloud-native system, and they're valuable in several scenarios:

### Distributed Systems Communication
- When you have multiple services that need to communicate asynchronously
- For microservices architectures where events flow between different components
- When integrating with cloud providers' event-driven services

### Audit Trail & Logging
- Tracking important business events (user signups, orders, payments)
- Creating consistent logging formats across different systems
- Maintaining a record of system-wide state changes

### Integration Scenarios
- When connecting with third-party services
- For webhook implementations
- Building event-driven APIs

### Common Use Cases:
- User actions (registration, login, profile updates)
- Business transactions (orders, payments, refunds)
- System events (backup completed, error occurred)
- Resource state changes (document updated, image processed)


The key benefit is that cloud events provide a consistent, standardized format for event data across different systems and platforms, making it easier to build reliable, interoperable event-driven architectures.

### Example 1: User Registration Event

You may wish to dispatch an event when a user registers on your platform. Here's an example of how you could create a Cloud Event for this:

```php
use JustSteveKing\CloudEvents\CloudEvent;

$registrationEvent = CloudEvent::make([
    'id' => uniqid(),
    'source' => '/auth/register',
    'type' => 'com.example.user.registered',
    'data' => json_encode([
        'user_id' => 123,
        'email' => 'user@example.com',
        'registered_at' => '2023-01-01T12:00:00Z'
    ]),
    'dataContentType' => 'application/json',
]);
```

### Example 2: Order Created Event

You may wish to dispatch an event when an order is created on your platform. Here's an example of how you could create a Cloud Event for this:

```php
use JustSteveKing\CloudEvents\CloudEvent;

$orderEvent = CloudEvent::make([
    'id' => uniqid(),
    'source' => '/orders',
    'type' => 'com.example.order.created',
    'data' => json_encode([
        'order_id' => 'ORD-123',
        'customer_id' => 456,
        'total' => 99.99,
        'items' => ['SKU-1', 'SKU-2']
    ]),
    'dataContentType' => 'application/json',
]);
```

### Example 3: File Upload Event

You may wish to dispatch an event when a file is uploaded to your platform. Here's an example of how you could create a Cloud Event for this:

```php
use JustSteveKing\CloudEvents\CloudEvent;

$uploadEvent = CloudEvent::make([
    'id' => uniqid(),
    'source' => '/storage/files',
    'type' => 'com.example.file.uploaded',
    'data' => json_encode([
        'file_name' => 'document.pdf',
        'size' => 1024567,
        'mime_type' => 'application/pdf',
        'storage_path' => '/uploads/2023/01/document.pdf'
    ]),
    'dataContentType' => 'application/json',
    'subject' => 'document.pdf'
]);
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

For more information, visit the [GitHub repository](https://github.com/Treblle/cloudevent-php).
