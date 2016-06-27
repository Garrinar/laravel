<?php

namespace App\Models\Logs;

use App\Models\Core\AbsModel;

/**
 * Class SmsApiLog
 * @package App\Models\Logs
 *
 *
 * @property int $id
 * @property int $sms_id
 * @property string $request
 * @property string $response
 * @property $created_at
 * @property $updated_at
 */
class SmsApiLog extends AbsModel
{
    protected $fillable = ['response', 'request'];
}
