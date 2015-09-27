Zulip PHP Client
====

Have been playing around with [Zulip](https://zulip.org/) and noticed there was no PHP client... So I made one! 

## Installation
Using composer!
```bash
composer require mrferos/zulip-php:^0.1.0
```

## Usage:
Using the client is simple, instantiate it with the URL to your Zulip instance and pass the default authentication
object (on a per request basis you can specify different authentication in case you need/want to send messages
as different users per requests).

### Example:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new \Zulip\Client('http://localhost:9991');
$client->setDefaultAuthentication(new \Zulip\Authentication('feedback@zulip.com', '7Rp5bNRVz1dSuDz4HhANaxlpNDcYb6GQ'));
$client->sendMessage([
    'to' => 'Denmark',
    'content' => 'content',
    'type' => \Zulip\Request\MessageParameters::TYPE_STREAM,
    'subject' => 'subject'
]);

// or.. (this is what happens under the code if you pass an array)

$parameters = new \Zulip\Request\MessageParameters();
$parameters->setContent('Content of message');
$parameters->setTo('Denmark');
$parameters->setType(\Zulip\Request\MessageParameters::TYPE_STREAM);
$parameters->setSubject('This is the subject');

$client->sendMessage($parameters);

```

## TODO:
- [ ] Write tests
- [ ] Implement the rest of the API
- [ ] More documentation!
