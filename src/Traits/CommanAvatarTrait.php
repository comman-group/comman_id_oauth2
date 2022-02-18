<?php

declare(strict_types=1);

namespace Comman\OAuth2\Client\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Трейт фотографии пользователя COMMAN_ID
 */
trait CommanAvatarTrait
{
    private string $COMMAN_ID_IMAGE_URL = 'https://id.comman.com/image';
   
    /**
     * Имя файла картинки
     *  
     * @ORM\Column(type="string", nullable=false, length=100)
     * 
     * @Assert\Length(max=100)
     */
    private string $commanImageFile;

    
    public function getCommanImageFile(): null|string
    {
        return $this->commanImageFile;
    }

    public function setCommanImageFile(string $commanImageFile): self
    {

        $this->commanImageFile = $commanImageFile;

        return $this;
    }

    public function getAvatar(int $width = 300, int $height = null): null|string
    {
        if (!$this->commanImageFile) {
            return null;
        }
        
        if (is_null($height)) {
            $height = $width;
        }

        $if = $this->commanImageFile;

        return $this->COMMAN_ID_IMAGE_URL . '/' . substr($if,0,2) . '/' . substr($if,2,2) . '/' . substr($if,4,2) . '/' . substr($if,6,2) . '/' . str_replace('.', '__' . $width . 'x' . $height.'.', $if);
    }
}
   