<?php

namespace App\Models\Core;


/**
 * Class Department
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $fax
 * @property string $phone
 * @property string $emails
 */
class Department extends AbsModel
{

    /**
     * @return Companies
     */
    public function company()
    {
        return $this->belongsTo(Companies::class)->first();
    }
}
