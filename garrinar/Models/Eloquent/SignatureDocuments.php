<?php

namespace App\Models\Core;

/**
 * Class SignatureDocuments
 * @package App\Models\Core
 *
 * 
 */
class SignatureDocuments extends AbsModel
{
    public $location_x = 0;
    public $location_y = 0;
    public $offset_src_x = 0;
    public $offset_src_y = 0;
    public $src_height = 35;
    public $src_width = 70;
    public $no_transparent = 100;
    public $document_png_path = '';
    public $signature_path = '';
    public $document_pdf_path = '';
    
    public static function signatureDocument($document_path = '', $signature_path = '', $pdf_path = '', $data){
        $signature = imagecreatefromstring(file_get_contents($signature_path));
        $document = imagecreatefromstring(file_get_contents($document_path));

        $location_x = (int) $data["location_x"];
        $location_y = (int) $data["location_y"];
        $offset_src_x = 0;
        $offset_src_y = 0;
        $src_width = 120;
        $src_height = 60;
        $no_transparent = 100;
        
        $source_imagex = imagesx($signature);
        $source_imagey = imagesy($signature);

        $dest_imagex = $src_width;
        $dest_imagey = $src_height;

        $signature_place = imagecreatetruecolor($src_width, $src_height);
        imagecopyresampled($signature_place, $signature, 0, 0, 0, 0,
        $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);

        imagecopymerge($document, $signature_place, $location_x, $location_y, $offset_src_x, $offset_src_y, $src_width, $src_height, $no_transparent);
        imagealphablending($document, true);
        imagesavealpha($document, true);

        imagepng($document, $document_path);

        if(!empty($pdf_path)){
            $im = new \Imagick();

//            ob_start();
//            imagepng($document);
//            $image_data = ob_get_contents();
//            ob_end_clean();

            // Get image source data
            $im->setResolution(100, 100);
            //$im->readimageblob($image_data);
            $im->readImage($document_path);
            $im->setImageFormat('pdf');
            $im->writeImage($pdf_path);
        }
        
        imagedestroy($document);
        imagedestroy($signature);
        imagedestroy($signature_place);
        return true;
    }
}
