<?php
/**
 * Created by PhpStorm.
 * User: Garrinar
 * Date: 19.05.2016
 * Time: 16:32
 */

namespace App\Models\Telepele;


/**
 * Class SendFaxStatus
 * @package App\Models\Telepele\Requests
 *
 *
 * @property string $faxCode
 */
class FaxStatus extends AbsRequest
{
    const
        FAX_STATUS_INIT = 0,
        FAX_STATUS_CONFIRM = 1,
        FAX_STATUS_NO_ANSWER = 2,
        FAX_STATUS_BUSY = 3,
        FAX_STATUS_CONNECT = 4, // fax
        FAX_STATUS_WRONG_NUMBER = 6,
        FAX_STATUS_FAIL = 7,
// fax send success
        FAX_STATUS_SENT = 9,
        FAX_STATUS_DELETE = 10;

    protected
        $action = 'faxStatus.do';

}