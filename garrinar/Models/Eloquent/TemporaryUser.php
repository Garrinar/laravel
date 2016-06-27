<?php

namespace App\Models\Core;

use App\Traits\ErrorsTrait;


/**
 * Class TemporaryUser
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string $id_number
 * @property string $phone
 * @property string $email
 * @property string $insurance_agency
 * @property int $logo_file_id
 * @property string $street
 * @property string $house_number
 * @property string $zip_code
 * @property string $city
 * @property string $mailbox
 * @property string $password
 * @property int $token_id
 * @property $created_at
 * @property $updated_at
 */
class TemporaryUser extends AbsModel
{
    use ErrorsTrait;

    protected $fillable = [
        'id',
        'first_name',
        'second_name',
        'id_number',
        'phone',
        'email',
        'insurance_agency',
        'logo_file_id',
        'street',
        'house_number',
        'zip_code',
        'city',
        'mailbox',
        'faxes_sent',
        'faxes_total',
        'password',
        'token_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'token_id',
        'created_at',
        'updated_at',
    ];

    public function moveToUsers()
    {
        $user = User::query()->where('email', $this->email)->first();
        if (!$user) {
            $movedUser = new User($this->toArray());
            if (!$movedUser->logo_file_id) {
                $movedUser->logo_file_id = 0;
            }
            if ($movedUser->save()) {
                $this->query()->delete();
                return $movedUser;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function validate()
    {
        if (mb_strlen($this->password) < 3) {
            $this->addError('password', 'Minimal password length is 3 chars');
        }

        return $this->hasErrors();
    }
}
