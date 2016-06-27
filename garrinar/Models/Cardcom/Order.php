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
 */
class CreateOrder extends Request
{
    const
        INVOICE_LANGUAGE_ENGLISH = 'en',
        INVOICE_LANGUAGE_HEBREW = 'he';

    public function __construct()
    {
        parent::__construct();

        //set default values
        $this->Operation = self::OPERATION_SUSPENDED_DEAL;
    }


}