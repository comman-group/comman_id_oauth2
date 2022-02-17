<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Трейт фотографии пользователя COMMAN_ID
 */
trait AboutTrait
{
    static const COMMAN_ID_IMAGE_URL = 'https://id.comman.com/image';
   
    /**
     * Файл картинки
     */
    private string $commanImageFile;

    
    public function getCommanImageFile(): ?string
    {
        return $this->commanImageFile;
    }

    public function setCommanImageFile(string $commanImageFile): ?self
    {

        $this->commanImageFile = $commanImageFile;

        return $this;
    }

    public function getAvatar(int $width = 300, int $height = null)
    {
        if (is_null($height)) {
            $height = $width;
        }

        $if = $this->commanImageFile;

        return self::COMMAN_ID_IMAGE_URL . '/' . substr($if,0,2) . '/' . substr($if,2,2) . '/' . substr($if,4,2) . '/' . substr($if,6,2) . '/' . str_replace($if, '.', '__' . $width . 'x' . $height.'.');
    }
}
   