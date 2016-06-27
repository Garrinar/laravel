<?php

namespace App\Models\Core;


/**
 * Class Package
 * @package App\Models\Core
 */
class Package extends AbsModel
{
    public static function buy(PackageTypes $packageType, User $user)
    {
        $payment = new Payment();
        $payment->price = $packageType->price;
        $payment->agent_id = $user->id;
        $payment->description = $packageType->name;

        /** @var PaymentsTokens $paymentToken */
        $paymentToken = PaymentsTokens::query()->where(['user_id' => $user->id]);
        if($paymentToken) {
            $payment->payment_token = $paymentToken->token;
            $payment->billFromToken();
        } else {
            $payment->billAndCreateToken();
        }
        
        return $payment;
    }
}
