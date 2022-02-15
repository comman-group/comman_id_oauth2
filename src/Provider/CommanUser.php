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
     * @var array Массив с данными о пользователе
     */
    protected $data;

    public function __construct(array $response)
    {
        $this->data = $response;
    }
    
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

    /**
     * Элемент массива данных о пользователе
     *
     * @param string $key Ключ поля (например: email или name.first — вложенность оформляется точкой)
     * @return mixed|null
     */
    protected function getField(string $key)
    {
        return static::getFieldFromArray($key, $this->data);
    }

    /**
     * Значение массива (многомерного)
     *
     * @param string $key Ключ поля (например: `email` или `name.first` — вложенность оформляется точкой)
     * @return mixed|null
     */
    public static function getFieldFromArray(string $key, ?array $array)
    {
        if (strpos($key, '.')) { // key.subKey.subSubKey
            list ($key, $subKey) = explode('.', $key, 2);
            return isset($array[$key]) ? static::getFieldFromArray($subKey, $array[$key]) : null;
        }

        return isset($array[$key]) ? $array[$key] : null;
    }
}