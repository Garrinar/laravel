<?php

namespace App\Models\Api {

    use App\Models\Core\AbsModel;


    /**
     * Class Token
     * @package App\Models\Api
     *
     *
     * @property int $id
     * @property string $token
     * @property $created_at
     * @property $updated_at
     */
    class Token extends AbsModel
    {
        protected $fillable = [
            'token',
        ];

        /**
         * Generate token
         *
         * @return string
         */
        public static function generate()
        {
            return md5(microtime() . env('APP_KEY'));
        }

        public function isValid()
        {
            return $this->query()->where('token', $this->token)->first() != false;
        }

        /**
         * @param string $token
         * @return bool
         *
         * @deprecated since 09.05.2016
         * @see Token::findByToken()
         */
        public static function getID($token)
        {
            /** @var static $token */
            $token = self::findByToken($token);
            return
                $token
                    ? $token->id
                    : false;
        }

        public static function findByToken($token)
        {
            return
                self::query()
                    ->where(['token' => $token])
                    ->first();
        }

        /**
         * @return string
         */
        public function getRouteKeyName()
        {
            return 'token';
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return $this->token;
        }
    }
}
