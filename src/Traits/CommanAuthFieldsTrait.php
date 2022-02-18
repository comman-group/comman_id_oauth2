<?php

declare(strict_types=1);

namespace Comman\OAuth2\Client\Traits;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Трейт фотографии пользователя COMMAN_ID
 */
trait CommanAuthFieldsTrait
{   
    /**
     * Идентификатор пользователя COMMAN ID (UUID)
     * 
     * @ORM\Column(type="string", length=64, unique=true, options={"fixed":true}, nullable=true)
     * 
     * @Assert\Length(max=64)
     * @Assert\Uuid
     */
    private null|string $commanId;

    /**
     * Данные пользователя UserInfo COMMAN ID
     * 
     * @ORM\Column(type="json", nullable=true)
     */
    private null|array $commanUserInfo;

    /**
     * Токены COMMAN ID
     * 
     * @ORM\Column(type="json", nullable=true)
     */
    private null|array $commanToken;

    public function getCommanId(): null|string
    {
        return $this->commanId;
    }

    public function setCommanId(?string $commanId): self
    {
        $this->commanId = $commanId;

        return $this;
    }

    public function getCommanUserInfo(): null|array
    {
        return $this->commanUserInfo;
    }

    public function setCommanUserInfo(?array $commanUserInfo): self
    {
        $this->commanUserInfo = $commanUserInfo;

        return $this;
    }

    public function getCommanToken(): null|AccessToken
    {
        return $this->commanToken ? new AccessToken($this->commanToken) : null;
    }

    public function setCommanToken(?AccessToken $accessToken): self
    {
        $this->commanToken = $accessToken ? $accessToken->jsonSerialize() : null;

        return $this;
    }
}
   