<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 19.05.2016
 * Time: 16:32
 */

namespace App\Models\Telepele;


/**
 * Class RegisterMyFaxUser
 * @package App\Models\Telepele\Requests
 * 
 *
 * @property string $distEmail
 * @property string $distPassword
 * @property string $fullName
 * @property string $companyName
 * @property string $companyAddress
 * @property string $type
 * @property string $requestedPhoneNumber
 */
class RegisterMyFaxUser extends AbsRequest
{
    protected 
        $action = 'myFaxAllocateDistributer.do';


    public function __construct()
    {
        // Init default values
        parent::__construct();
        $this->type = 1;
    }
    
    /**
     * @return bool
     */
    public function validate()
    {
        parent::validate();

        if (mb_strlen($this->fullName) > 200) {
            $this->errors[] = 'fullName max length is 200 chars';
        }

        if (mb_strlen($this->companyName) > 100) {
            $this->errors[] = 'companyName max length is 100 chars';
        }

        if($this->type !== 1 && $this->type !== 17) {
            $this->errors[] = 'type must be 1 or 17';
        }
    }

}