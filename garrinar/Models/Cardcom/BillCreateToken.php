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
 *
 * @property $IsCreateInvoice
 * @property $InvoiceHead_CustName
 * @property $InvoiceHead_SendByEmail
 * @property $InvoiceHead_Language
 * @property $InvoiceHead_Email
 * @property $InvoiceLines1_Description
 * @property $InvoiceLines1_Price
 * @property $InvoiceLines1_Quantity
 * @property $InvoiceLines2_Description
 * @property $InvoiceLines2_Price
 * @property $InvoiceLines2_Quantity
 *
 * @property $CreateTokenDeleteDate
 * @property $CreateTokenJValidateType
 */
class BillCreateToken extends Request
{
    const
        INVOICE_LANGUAGE_ENGLISH = 'en',
        INVOICE_LANGUAGE_HEBREW = 'he';

    /*
      Type of test to be performed on the card
        J2- Testing only told criticism of the card.
J5 - Test and booking of the transferred amount.
    you will receive One-time confirmation code.
    The confirmation code need to be transfer to cardcom systems when billing should be done.
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
        $this->Operation = self::OPERATION_BILL_AND_CREATE_TOKEN;
        $this->IsCreateInvoice = "true";
        $this->InvoiceHead_SendByEmail = "true";
        $this->InvoiceHead_Language = self::INVOICE_LANGUAGE_HEBREW;
        $this->CreateTokenDeleteDate = Carbon::create()->addYears(10)->format('d/m/Y');
        $this->CreateTokenJValidateType = self::TOKEN_VALIDATION_TYPE_J2;
    }


}