<?php

namespace App\Models\Core;

use App\Models\Logs\FaxApiLog;
use App\Models\Telepele\FaxStatus;
use App\Models\Telepele\SendFax;
use Psy\Util\Json;

/**
 * Class Fax
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property string $fax_number
 * @property string $file
 * @property int $status
 * @property $created_at
 * @property $updated_at
 */
class Fax extends AbsModel
{
     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
    
   
    /**
     * @param SendFax $request
     * @return Fax
     */
    public static function send(SendFax $request)
    {
        $fax = new self();
        $result = $request->send();
        $fax->fax_number = $request->faxNumber;
        $fax->status = FaxStatus::FAX_STATUS_INIT;
        $fax->file = $request->file->getUrl();
        $fax->save();
        self::_log($result);
        return $fax;
    }

    public static function getStatus(FaxStatus $request)
    {
        $fax = new self();
        $result = $request->send();
    }

    /**
     *
     * @param $result
     * @return FaxApiLog
     */
    protected static function _log($result)
    {
        $log = new FaxApiLog();
        $log->request = Json::encode($result['request']);
        $log->response = Json::encode($result['response']);
        $log->save();
        return $log;
    }
}
