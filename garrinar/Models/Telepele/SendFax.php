<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 19.05.2016
 * Time: 16:32
 */

namespace App\Models\Telepele;


/**
 * Class SendFax
 * @package App\Models\Telepele\Requests
 * 
 *
 * @property string $faxNumber
// * @property string $theFile
// * @property string $fileUrl
 */
class SendFax extends AbsRequest
{
    protected 
        $action = 'faxUpload.do';
    
}