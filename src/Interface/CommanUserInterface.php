<?php

declare(strict_types=1);

namespace Comman\OAuth2\Client\Interface;

use League\OAuth2\Client\Token\AccessToken;

/**
 * COMMAN User interface
 *
 * @author Dariusz Górecki <darek.krk@gmail.com>
 */
interface CommanUserInterface
{
   
    public function getCommanId(): null|string;

    public function getCommanUserInfo(): null|array;

    public function getCommanToken(): null|AccessToken;
}
