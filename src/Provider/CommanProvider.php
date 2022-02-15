<?php

declare(strict_types=1);

namespace Comman\OAuth2\Client\Provider;

use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * Провайдер данных Первого сентября
 */
class CommanProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var string Сервер аутентификации (Личный кабинет Первое сентября)
     */
    const AUTH_BASE = 'https://id.1sept.ru';

    /**
     * @var string API Первое сентября
     */
    const API_BASE = 'https://id.1sept.ru/api/oauth';

    /**
     * @var string Версия API
     */
    const API_VERSION = '2.0';

    /**
     * @inheritDoc
     */
    public function getBaseAuthorizationUrl(): string
    {
        return static::AUTH_BASE.'/authorize';
    }

    /**
     * @inheritDoc
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return static::API_BASE.'/access_token';
    }

    /**
     * @inheritDoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return static::API_BASE.'/'.static::API_VERSION.'/userinfo';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultScopes(): array
    {
        return ['PROFILE'];
    }

    /**
     * @inheritDoc
     */
    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (!empty($data['error'])) {
            throw new IdentityProviderException($data['error'].': '.$data['message'], null, $response);
        }
    }

    /**
     * @inheritDoc
     */
    protected function createResourceOwner(array $response, AccessToken $token): CommanUser
    {
        return new CommanUser($response);
    }
}
