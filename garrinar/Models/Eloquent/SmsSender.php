<?php

namespace App\Models\Core;


/**
 * Class Sms
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property int $token_id
 * @property string $phone
 * @property int $message
 * @property int $status
 * @property $created_at
 * @property $updated_at
 *
 * @see http://www.smsender.co.il/install/doc/httpgeteng.html
 */
class SmsSender
{
    const
        URL = "http://www.cardcom.co.il/SendSMS/Sendsms.aspx",
        NAME = "038246237",
        FROM = "0533363561",
        PASS = "DGL24LHIMT";

    public static function send(Sms $sms)
    {
        $content = [
            'msg' => $sms->message,
            'name' => self::NAME,
            'pass' => self::PASS,
            'from' => self::FROM,
            'to' => $sms->phone,
            'codepage' => 65001
        ];
        
        $str = '';
        foreach ($content as $k => $v) {
            $str .= $k . '=' . urlencode($v) . '&';
        }

        $str = trim($str, '&');
        if (env('API_SMS', true)) {
            $response = file_get_contents(self::URL . '?' . $str);
        } else {
            $response = 'Sms api is turned off';
        }

        return ['response' => $response, 'request' => $str];
    }
}