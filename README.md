# Cloud Events PHP

Welcome to the **Cloud Events PHP** repository! This library enables you to create and manage Cloud Events in PHP with ease.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
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

$event = new CloudEvent([
    'type' => 'com.example.someevent',
    'source' => '/mycontext',
    'id' => '1234-1234-1234',
    'time' => '2020-09-30T12:34:56Z',
    'data' => [
        'key' => 'value',
    ],
]);

echo $event->toJson();
```

## Features

- Easy creation and management of Cloud Events
- Support for JSON serialization
- Flexible event data structure

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

For more information, visit the [GitHub repository](https://github.com/Treblle/cloudevent-php).
