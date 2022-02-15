# COMMAN ID oauth2 client

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides [COMMAN](https://id.comman.com) integration for [OAuth2 Client](https://github.com/thephpleague/oauth2-client) by the League.

## Installation

Just execute:
```sh
composer require comman-group/comman_id_oauth2
```

## Usage

```php
$provider = new \Comman\OAuth2\Client\Provider\CommanProvider([
    'clientId' => 'client_id',
    'clientSecret' => 'secret',
    'redirectUri' => 'https://example.org/oauth/endpoint',
]);
```
