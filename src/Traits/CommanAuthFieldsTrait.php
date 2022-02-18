<?php

namespace Comman\OAuth2\Client\Traits;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Трейт фотографии пользователя COMMAN_ID
 */
trait CommanAuthFieldsTrait
{
    const COMMAN_ID_IMAGE_URL = 'https://id.comman.com/image';
   
    /**
     * Идентификатор пользователя COMMAN ID (UUID)
     * 
     * @ORM\Column(type="string", length=64, unique=true, options={"fixed":true}, nullable=true)
     */
    private ?string $commanId;

    /**
     * Данные пользователя UserInfo COMMAN ID
     * 
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $commanUserInfo;

    /**
     * Токены COMMAN ID
     * 
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $commanToken;

    public function getCommanId(): ?string
    {
        return $this->commanId;
    }

    public function setCommanId(?string $commanId): self
    {
        $this->commanId = $commanId;

        return $this;
    }

    public function getCommanUserInfo(): ?array
    {
        return $this->commanUserInfo;
    }

    public function setCommanUserInfo(?array $commanUserInfo): self
    {
        $this->commanUserInfo = $commanUserInfo;

        return $this;
    }

    public function getCommanToken(): ?AccessToken
    {
        return $this->commanToken ? new AccessToken($this->commanToken) : null;
    }

    public function setCommanToken(?AccessToken $accessToken): self
    {
        $this->commanToken = $accessToken ? $accessToken->jsonSerialize() : null;

        return $this;
    }
}
   