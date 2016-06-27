<?php namespace App\Models\Core;

use App\Models\Api\Token;
use App\Traits\ErrorsTrait;
use Carbon\Carbon;

/**
 * Class Users
 * @package App
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
 * @property int $faxes_sent
 * @property int $faxes_total
 * @property int $package_type_id
 * @property int $status
 * @property string $password
 * @property string $remember_token
 * @property string $remember_token_expire_at
 * @property int $token_id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $session_expire_at
 */
class Users extends AbsModel
{
    use ErrorsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
        'package_type_id',
        'status',
        'password',
        'remember_token',
        'remember_token_expire_at',
        'token_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'token_id',
        'remember_token',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function activatePackage(PackageTypes $packageType)
    {
        if($this->faxes_total >$this->faxes_sent) {
            
        }
    }

    /**
     * @return Files
     */
    public function logoFile()
    {
        return $this->belongsTo(Files::class)->first();
    }

    public static function register($data)
    {
        $user = new TemporaryUser(collect($data)->except('confirm_password')->toArray());
        $user->validate();

        if($data['password'] != $data['confirm_password']) {
            $user->addError('password', 'Passwords mismatch');
        }

        if(!$user->hasErrors()) {
            $isRegistered = self::query()->where('email', $data['email'])->first();

            if($isRegistered) {
                $user->addError('email', 'Email already registered');
            } else {
                $user->password = self::encodePassword($user->password);
                $user->save();
            }
        }
        return $user;
    }

    public function validate()
    {
        if(mb_strlen($this->password) < 3) {
            $this->addError('password', 'Minimal password length is 3 chars');
        }

        return $this->hasErrors();
    }

    public static function authorize($login, $password, Token $token)
    {
        /** @var self $user */
        $user = self::query()->where(['email' => $login])->first();
        if(!$user) {
            $user = new self();
            $user->addError('email', 'Login or password incorrect');
        }

        if($user->password != self::encodePassword($password)) {
            $user->addError('password', 'Login or password incorrect');
        }

        if(!$user->hasErrors()) {
            $user->token_id = $token->id;
            $user->save();
        }

        return $user;
    }

    public static function unAuthorize(Token $token)
    {
        if(!$token->exists) {
            return false;
        }

        /** @var self $user */
        $user = self::query()->where('token_id', $token->id)->first();
        if($user) {
            $user->token_id = null;
            $user->save();
        }

        return true;
    }

    public static function isAuthorized(Token $token)
    {
        if(!$token->exists) {
            return false;
        }

        /** @var self $user */
        $user = self::query()->where('token_id', $token->id)->first();
        if(!$user) {
            return false;
        }

        if(Carbon::parse($user->updated_at)->addDay()->getTimestamp() < Carbon::now()->getTimestamp()) {
            $user->unAuthorize($token);
            return false;
        }

        return true;
    }

    /**
     * @param Token $token
     * @return \Illuminate\Database\Eloquent\Collection|static
     */
    public static function get(Token $token)
    {
        if(!$token->exists) {
            return new self();
        }
        return self::query()->where('token_id', $token->id)->first();
    }

    public static function encodePassword($password)
    {
        return md5(env('APP_KEY') . $password);
    }

    public static function getType(Token $token = null)
    {
        if(self::isAuthorized($token)) {
            return 'agent';
        } else {
            if($token->exists) {
                return 'user';
            } else {
                return 'guest';
            }
        }
    }

    public function setDeleted()
    {
        if (!$this->exists) {
            return false;
        } else {
            $this->deleted_at = Carbon::now()->toDateTimeString();
            return $this->save();
        }
    }

    public function setUnDeleted()
    {
        if (!$this->exists) {
            return false;
        } else {
            $this->deleted_at = null;
            return $this->save();
        }
    }

    public function isValid()
    {
        return true;
    }
}