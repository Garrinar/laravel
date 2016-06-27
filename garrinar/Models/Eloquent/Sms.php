<?php

namespace App\Models\Core;

use App\Models\Logs\SmsApiLog;

/**
 * Class Sms
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property int $token_id
 * @property string $phone
 * @property string $message
 * @property int $status
 * @property $created_at
 * @property $updated_at
 */
class Sms extends AbsModel
{
    const
        STATUS_IN_QUEUE = 1,
        STATUS_SEND = 2,
        STATUS_DELIVERED = 3,
        STATUS_NOT_DELIVERED = 4,
        STATUS_CANCELLED = 5,
        STATUS_UNKNOWN_ERROR = 99;


    public static function generateCode()
    {
        $generator = \Faker\Factory::create();
        return $generator->numerify("####");
    }

    public function send()
    {
        $this->save();
        $log = new SmsApiLog(SmsSender::send($this));
        $log->sms_id = $this->id;
        $log->save();

        return true;
    }
}