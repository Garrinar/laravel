<?php


namespace Garrinar\Helpers\Files;


class Pdf
{
    public $renderer;

    public function __construct()
    {
        $this->renderer = new \mPDF();
        return $this;
    }
    
    public function setContent($html)
    {
        $this->renderer->WriteHTML($html);
    }

    public function getPng($resolutionX = 100, $resolutionY = 100)
    {
        $img = new \Imagick();
        $img->setResolution($resolutionX, $resolutionY);
        $img->readImageBlob($this->get());
        $img->setImageFormat('png');
        return $img->getImageBlob();
    }

    public function get()
    {
        ob_start();
        $this->renderer->Output();
        return ob_get_clean();
    }
}