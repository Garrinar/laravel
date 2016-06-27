<?php
/**
 * Created by PhpStorm.
 * User: garrinar
 * Date: 16.06.16
 * Time: 16:09
 */

namespace App\Models\Cardcom;
use Carbon\Carbon;

/**
 * Class CreateInvoice
 * @package App\Models\Cardcom
 *
 * @property $CreateTokenDeleteDate
 * @property $CreateTokenJValidateType
 */
class CreateToken extends Request
{

    /*
   Type of test to be performed on the card
     J2- Testing only told criticism of the card.
J5 - Test and booking of the transferred amount.
 you will recive One-time confirmation code.
 The confirmation code need to be transpfer to cardcom systems when billing should be done.
 Using J5 subject to approval of credit card company.
 Parameter obtained approval will be show in Indicator ( Notify)  URL : TokenApprovalNumber
  */
    const
        TOKEN_VALIDATION_TYPE_J2 = '2',
        TOKEN_VALIDATION_TYPE_J5 = '5';
    
    public function __construct()
    {
        parent::__construct();

        //set default values
        $this->CreateTokenDeleteDate = Carbon::create()->addYears(10)->format('d/m/Y');
        $this->CreateTokenJValidateType = self::TOKEN_VALIDATION_TYPE_J2;
        $this->Operation = self::OPERATION_TOKEN;
    }
}