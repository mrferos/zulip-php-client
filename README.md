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
