<?php
/**
 * Created by PhpStorm.
 * User: garrinar
 * Date: 16.06.16
 * Time: 16:09
 */

namespace App\Models\Cardcom;

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
 */
class Bill extends Request
{

    const
        INVOICE_LANGUAGE_ENGLISH = 'en',
        INVOICE_LANGUAGE_HEBREW = 'he';

    public function __construct()
    {
        parent::__construct();

        //set default values
        $this->IsCreateInvoice = "true";
        $this->InvoiceHead_SendByEmail = "true";
        $this->InvoiceHead_Language = self::INVOICE_LANGUAGE_HEBREW;
        $this->Operation = self::OPERATION_BILL;
    }



}