<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentsInformationLog
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property int $token_id
 * @property string $event
 * @property string $message
 * @property string $ip
 * @property string $gps
 * @property $created_at
 * @property $updated_at
 */
class DocumentsInformationLog extends AbsModel
{
    //

    public function token()
    {
        return $this->belongsTo('App\Models\Api\Token')->first();
    }

}
