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

    public function saveToFile($fileName)
    {

    }

    public function get()
    {
        ob_start();
        $this->renderer->Output();
        return ob_get_clean();
    }
}