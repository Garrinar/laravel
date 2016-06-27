<?php

namespace App\Models\Cardcom;


/**
 * Class Request
 * @package App\Models\Cardcom
 *
 *
 * @property $TerminalNumber
 * @property $UserName
 * @property $APILevel
 * @property $codepage
 * @property $Operation
 * @property $Language
 * @property $CoinID
 * @property $SumToBill
 * @property $ProductName
 * @property $SuccessRedirectUrl
 * @property $ErrorRedirectUrl
 * @property $CancelType
 * @property $CancelUrl
 * @property $IndicatorUrl
 * @property $ReturnValue
 * @property $MaxNumOfPayments
 */
abstract class Request
{
    protected $url = 'https://secure.cardcom.co.il/Interface/LowProfile.aspx';
    protected $error = '';
    protected $request;
    protected $response;
    protected $responseCode;
    protected $data = [];


    const //he- hebrew , en - english , ru , ar
        LANG_RUSSIAN = 'ru',
        LANG_ENGLISH = 'en',
        LANG_HEBREW = 'he',
        LANG_ARABIC = 'ar';

    const
        OPERATION_BILL = 1,
        OPERATION_BILL_AND_CREATE_TOKEN = 2,
        OPERATION_TOKEN = 3,
        OPERATION_SUSPENDED_DEAL = 4;

    const
        COIN_ILS = 1,
        COIN_USD = 2,
        COIN_USD2 = 840,
        COIN_AUD = 36,
        COIN_CAD = 124,
        COIN_DKK = 208,
        COIN_JPY = 392,
        COIN_NZD = 554,
        COIN_RUB = 643,
        COIN_CHF = 756,
        COIN_GBP = 826,
        COIN_EUR = 978;
    
    const 
        CANCEL_TYPE_BUTTON_SHOW  = 2,
        CANCEL_TYPE_DO_NOT_SHOW = 0;



    public function __construct()
    {
        //setting auth params
//        $this->TerminalNumber = '1000';
//        $this->UserName = 'card9611';
        $this->TerminalNumber = '37133';
        $this->UserName = 'j9FRD6OjljN6hLJPDUTn';
//        password eZQadixDGjqITliGwwmg
        //setting default parameters
        $this->APILevel = 10;
        $this->codepage = 65001;
        $this->Language = self::LANG_HEBREW;
        $this->CoinID = self::COIN_ILS;
        $this->SuccessRedirectUrl = "https://secure.cardcom.co.il/DealWasSuccessful.aspx";
        $this->ErrorRedirectUrl = "https://secure.cardcom.co.il/DealWasUnSuccessful.aspx";
        $this->IndicatorUrl = env('APP_URL').'/payment/process';
    }

    public function send()
    {
        $this->request = http_build_query($this->toArray());
        if(env('API_PAYMENT', true) != false) {
            //init curl connection
            if (function_exists("curl_init")) {
                $CR = curl_init();
                curl_setopt($CR, CURLOPT_URL, $this->url);
                curl_setopt($CR, CURLOPT_POST, 1);
                curl_setopt($CR, CURLOPT_FAILONERROR, true);
                curl_setopt($CR, CURLOPT_POSTFIELDS, $this->request);
                curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($CR, CURLOPT_FAILONERROR, true);
                parse_str(curl_exec($CR), $this->response);
                $this->responseCode = $this->response['ResponseCode'];
                $this->error = curl_error($CR);
                curl_close($CR);
            } else {
                $this->error = "No curl_init";
            }
        } else {
            $this->response = 'payment system turned off';
        }


        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return !empty($this->getError());
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getToken()
    {
        return isset($this->response['LowProfileCode']) ? $this->response['LowProfileCode'] : '';
    }

    public function toArray()
    {
        return $this->data;
    }

    public function __get($key)
    {
        return $this->data[str_replace('.', '_', $key)];
    }

    public function __set($key, $value)
    {
        $this->data[str_replace('_', '.', $key)] = $value;
    }
}