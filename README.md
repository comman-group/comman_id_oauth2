# COMMAN ID oauth2 client

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides [COMMAN](https://id.comman.com) integration for [OAuth2 Client](https://github.com/thephpleague/oauth2-client) by the League.

## Installation

## Configure repository in composer.json

```json

"repositories": [{
    "type": "git",
    "url": "https://github.com/comman-group/comman_id_oauth2"
    }
]

```

## Just execute:
```sh
composer require knpuniversity/oauth2-client-bundle
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

## Example of symfony controller


```php

<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Авторизатор COMMAN ID
 *
 */
class SecurityCommanController extends AbstractController
{
    use TargetPathTrait;

    /**
     * Инициализация авторизации
     *
     * @Route("/auth/comman/login", name= "auth_comman_login")
     * @param ClientRegistry $clientRegistry
     * @return RedirectResponse
     */
    public function login(Request $request, ClientRegistry $clientRegistry)
    {
        $request->getSession()->remove(Security::AUTHENTICATION_ERROR);

        // if ($request->headers->get('referer')) {
        //     $referer = Request::create($request->headers->get('referer'));
        //     $this->saveTargetPath($request->getSession(), 'main', $referer->getRequestUri()); // Удаляем домен для пути возврата (в целях безопасности)
        // }

        return $clientRegistry
            ->getClient('comman_oauth_client') // Key from config/packages/knpu_oauth2_client.yaml
            ->redirect(
                [],  // Scopes (default: Provider::getDefaultScopes())
                []   // Extra options to pass to the "Provider" class
            )
        ;
    }

    /**
     * Вывод ошибки авторизации
     *
     * @Route("/auth/comman/error",  name= "auth_comman_error")
     */
    public function error(Request $request): Response
    {
        $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);

        if (!$error) {
            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/TwigBundle/Exception/error403.html.twig', [
            'status_code' => 403,
            'status_text' => 'Авторизация отклонена! (' . $request->getSession()->get('_security.last_error')->getMessage() . ')' 
        ], new Response('', 403));
    }

    /**
     * After going to COMMAN ID, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     * 
     * При правильной настройке мы не должны сюда попадать
     *
     * @Route("/auth/comman/endpoint", name="auth_comman_endpoint")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        $client = $clientRegistry->getClient('comman_oauth_client');


        try {
            // the exact class depends on which provider you're using
            $user = $client->fetchUser();

            // do something with all this new power!
	        // e.g. $name = $user->getFirstName();
            dd($user);
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }
    }
}

```