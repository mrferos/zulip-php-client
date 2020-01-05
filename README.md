Zulip PHP Client
====

A simple Zulip client that copies the API surface (more or less) of [zulip-js](https://github.com/zulip/zulip-js)

## Installation
Using composer!
```bash
composer require mrferos/zulip-php
```

## Usage:

### Initialization

#### With API key
```php
$config = new \Zulip\Config('https://example.zulipchat.com', 'bot-email@test.com', 'example');
$client = new \Zulip\Client($config);
```

#### With zuliprc
```php
$config = \Zulip\Config::fromFile(); // if no argument is provided it defaults to ~/zuliprc
$client = new \Zulip\Client($config);
```
### Examples

#### Sending a message
```php
$client = new \Zulip\Client();
$response = $client->messages->send([
    'to' => 'general',
    'type' => 'stream',
    'topic' => 'test',
    'content' => "This is a test"
]);

if ($response->isSuccessful()) {
    // We sent a message!
}
```
#### Uploading a file and using it in a message
```php
$client = new \Zulip\Client($config);
$response = $client->messages->uploadFile(['filename' => '/tmp/dog.jpg']);
$client->messages->send([
    'to' => 'general',
    'type' => 'stream',
    'topic' => 'test',
    'content' => "This is a test of the lib functionality [PUPPY](${response['uri']})"
]);
```

## TODO

- [ ] Write tests
- [ ] Come up with an auto documentation solution
- [ ] Implement more of the API
