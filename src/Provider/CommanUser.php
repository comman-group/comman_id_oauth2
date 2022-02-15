<?php

declare(strict_types=1);

namespace Comman\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Пользователь COMMAN ID
 */
class CommanUser implements ResourceOwnerInterface
{

    /**
     * {@inheritdoc}
     */
    public function toArray() {
        return $this->data;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->getField('id');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSlug(): string
    {
        return $this->getField('slug');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLastName(): string
    {
        return $this->getField('last_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName(): string
    {
        return $this->getField('first_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getMiddleName(): ?string
    {
        return $this->getField('nickname');
    }
   
    /**
     * {@inheritdoc}
     */
    public function getSex(): ?string
    {
        switch ($this->getField('sex')) {
            case 'M':
                return 'male';

            case 'F':
                return 'female';

            default:
                return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): ?string
    {
        return $this->getField('email');
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthday(): ?\DateTime
    {
        return !empty($this->data['birthday']) ? new \DateTime($this->data['birthday']) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatarUrl(bool $rejectEmptyAvatar = false): ?string
    {
        return $this->getField('photo_max');
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileUrl(): ?string
    {
        return 'https://id.comman.com/';
    }
}

