<?php

namespace App\Models\Core;

use App\Models\Cardcom\BillCreateToken;
use App\Models\Cardcom\ChargeTokenAndInvoice;
use App\Models\Cardcom\CreateToken;
use App\Models\Cardcom\Request;

/**
 * Class Payment
 * @package App\Models\Core
 *
 *
 * @property $id
 * @property $token_id
 * @property $agent_id
 * @property $customerName
 * @property $price
 * @property $description
 * @property $payment_token
 * @property $request
 * @property $response
 * @property $response_code
 * @property $created_at
 * @property $updated_at
 */
class Payment extends AbsModel
{
    /** @var  Request */
    protected $paymentRequest;


    public function createToken()
    {
        $this->paymentRequest = new CreateToken();
        $this->sendRequest();
        return $this;
    }

    public function billAndCreateToken()
    {
        $this->paymentRequest = new BillCreateToken();
        $this->paymentRequest->InvoiceHead_CustName = $this->customerName;
        $this->paymentRequest->InvoiceLines1_Price = $this->price;
        $this->paymentRequest->InvoiceLines1_Description = $this->description;
        $this->paymentRequest->SumToBill = $this->price;
        
        $this->sendRequest();
        if($this->payment_token) {
            $paymentToken = new PaymentsTokens();
            $paymentToken->user_id = $this->agent_id;
            $paymentToken->token = $this->payment_token;
        }
        return $this;
    }

    public function billFromToken()
    {
        $this->paymentRequest = new ChargeTokenAndInvoice();
        $this->paymentRequest->TokenToCharge_CoinID = Request::COIN_ILS;

        $this->paymentRequest->TokenToCharge_Token = $this->payment_token;
//        $this->paymentRequest->InvoiceHead_CustName = $this->customerName;
//        $this->paymentRequest->InvoiceLines1_Price = $this->price;
//        $this->paymentRequest->InvoiceLines1_Description = $this->description;
//        $this->paymentRequest->SumToBill = $this->price;

        $this->sendRequest();

        return $this;
    }

    public function getPaymentRequest()
    {
        return $this->paymentRequest;
    }

    protected function sendRequest()
    {
        $this->response =
            json_encode(
                $this
                    ->paymentRequest
                    ->send()
                    ->getResponse()
            );

        $this->request =
            json_encode(
                $this
                    ->paymentRequest
                    ->getRequest()
            );

        $this->payment_token = $this->paymentRequest->getToken();
        $this->response_code = $this->paymentRequest->getResponseCode();

        $this->save();

        return $this;
    }
}