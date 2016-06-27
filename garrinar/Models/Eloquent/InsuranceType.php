<?php

namespace App\Models\Core;


/**
 * Class InsuranceType
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property string $name
 * @property int $department_id
 *
 */
class InsuranceType extends AbsModel
{
    /**
     * @return Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class)->first();
    }
}
