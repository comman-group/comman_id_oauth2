# COMMAN ID oauth2 client

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides [COMMAN](https://id.comman.com) integration for [OAuth2 Client](https://github.com/thephpleague/oauth2-client) by the League.

## Installation

##Configure repository in composer.json

```json

"repositories": [
    {
    "type": "git",
    "url": "https://github.com/comman-group/comman_id_oauth2"
    }
]

```

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

## Example of knpu_oauth2_client.yaml

```yaml

knpu_oauth2_client:
    clients:
        comman_oauth_client:
            type: generic
            provider_class: Comman\OAuth2\Client\Provider\CommanProvider
            client_id: '%env(OAUTH_COMMAN_ID)%'
            client_secret: '%env(OAUTH_COMMAN_SECRET)%'
            redirect_route: auth_comman_endpoint
            redirect_params: {}

```
