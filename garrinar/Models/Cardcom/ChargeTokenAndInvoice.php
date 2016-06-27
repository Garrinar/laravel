<?php
/**
 * Created by PhpStorm.
 * User: garrinar
 * Date: 17.06.16
 * Time: 11:11
 */

namespace App\Models\Cardcom;

/**
 * Class ChargeTokenAndInvoice
 * @package App\Models\Cardcom
 *
 *
 * @property $TokenToCharge_APILevel
 * @property $TokenToCharge_Token
 * @property $TokenToCharge_Salt
 * @property $TokenToCharge_CardValidityMonth
 * @property $TokenToCharge_CardValidityYear
 * @property $TokenToCharge_SumToBill
 * @property $TokenToCharge_CoinID
 * @property $TokenToCharge_NumOfPayments
 * @property $InvoiceHead_CustName
 * @property $InvoiceHead_CustAddresLine1
 * @property $InvoiceHead_CustAddresLine2
 * @property $InvoiceHead_CustCity
 * @property $InvoiceHead_CustLinePH
 * @property $InvoiceHead_CustMobilePH
 * @property $InvoiceHead_Language
 * @property $InvoiceHead_Email
 * @property $InvoiceHead_SendByEmail
 * @property $InvoiceLines_Description
 * @property $InvoiceLines_Price
 * @property $InvoiceLines1_Quantity
 * @property $InvoiceLines1_Description
 * @property $InvoiceLines1_Price
 */
class ChargeTokenAndInvoice extends Request
{
    protected $url = 'https://secure.cardcom.co.il/Interface/ChargeToken.aspx';

    public function __construct()
    {
        parent::__construct();

        $this->TokenToCharge_APILevel = '10';
        $this->TokenToCharge_Token = mb_strtoupper('9562a8da-2af2-48ce-8dd1-6ef122936f9f');
        $this->TokenToCharge_Salt = '10';
//$this->TokenToCharge_CardValidityMonth = '16';
//$this->TokenToCharge_CardValidityYear = '';
        $this->TokenToCharge_SumToBill = '10';
        $this->TokenToCharge_CoinID = '1';
        $this->TokenToCharge_NumOfPayments = '1';
    }
}

//
//# Create Array For Billing
//
//$vars = array(
//    'TerminalNumber' => '1000',
//    'UserName' => 'yael29',
//    'TokenToCharge.APILevel' => '9',
//    'TokenToCharge.Token' => 'D6D709D4-5ED0-4926-8629-E7924537065D',
//    'TokenToCharge.Salt' => '12421',  #User ID or a Cost var.
//    'TokenToCharge.CardValidityMonth' => '09',
//    'TokenToCharge.CardValidityYear' => '19',
//    'TokenToCharge.SumToBill' => '250.50',
//    'TokenToCharge.CoinID' => '1',
//    'TokenToCharge.NumOfPayments' => '1',
//    'CustomeFields.Field1' => 'Custom e Comments 1 ',
//    'CustomeFields.Field2' => 'Custom e Comments 2',
//    'codepage' => '65001', #UNICODE
//# invoice Option - optinal
//    'InvoiceHead.CustName' => 'customr Name',
//    'InvoiceHead.CustAddresLine1' => 'address line 1',
//    'InvoiceHead.CustAddresLine2' => 'address line 2',
//    'InvoiceHead.CustCity' => 'state',
//    'InvoiceHead.CustLinePH' => '039619611',
//    'InvoiceHead.CustMobilePH' => '0540000000',
//    'InvoiceHead.Language' => 'he',
//    'InvoiceHead.Email' => 'yaniv@SomeEmail.com',
//    'InvoiceHead.SendByEmail' => 'True',
//    'InvoiceLines.Description' => 'Item Line 1',
//    'InvoiceLines.Price' => '200',
//#'InvoiceLines.IsPriceIncludeVAT'=>'true',
//    'InvoiceLines1.Quantity' => '1',
//    'InvoiceLines1.Description' => 'Item Line 2',
//    'InvoiceLines1.Price' => '50.5',
//#'InvoiceLines1.IsPriceIncludeVAT'=>'true',
//    'InvoiceLines1.Quantity' => '1'
//);
//
//# urlencode the information
//$urlencoded = http_build_query($vars);
//
//
//#init curl connection
//if (function_exists("curl_init")) {
//    $CR = curl_init();
//    curl_setopt($CR, CURLOPT_URL, 'https://secure.cardcom.co.il/Interface/ChargeToken.aspx');
//    curl_setopt($CR, CURLOPT_POST, 1);
//    curl_setopt($CR, CURLOPT_FAILONERROR, true);
//    curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
//    curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
//
//
//    #actual curl execution perfom
//    $result = curl_exec($CR);
//    $error = curl_error($CR);
//    # some error , send email to developer
//    if (!empty($error)) {
//        echo $result;
//        echo "<br/>";
//        echo $message;
//        echo "<br/>";
//        echo $error;
//        return;
//    }
//
//    curl_close($CR);
//
//}
//$resultArray = array();
//parse_str($result, $resultArray); # ResponseCode={0}&Description={1}&InternalDealNumber={2}&InvoiceResponse.ResponseCode={3}&InvoiceResponse.Description={4}&InvoiceResponse.InvoiceNumber={5}&InvoiceResponse.InvoiceType={6}
//if (isset($resultArray['ResponseCode']) && $resultArray['ResponseCode'] == '0') # was charged OK!
//{
//    # chack if InvoiceResponse_ResponseCode == 0 to see if invoice is ok
//    # Save Invoice number and Type to DB :
//    echo 'InternalDealNumber:' . $resultArray['InternalDealNumber'];
//} else # some error , unable to charge toekn // log for informtation
//{
//
//    echo 'Error Code : ' . $resultArray['ResponseCode'] . '  Description:' . $resultArray['Description'];
//    echo "<br/>";
//    echo $result;
//
//
//}
//
//