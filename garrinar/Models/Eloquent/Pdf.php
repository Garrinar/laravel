<?php

namespace App\Models\Core;

class Pdf extends \Garrinar\Tools\Files\Pdf
{

    public function getPng($resolutionX = 100, $resolutionY = 100)    {
        $img = new \Imagick();
        $img->setResolution($resolutionX, $resolutionY);
        $img->readImageBlob($this->get());
        $img->setImageFormat('png');
        return $img->getImageBlob();
    }
}
