<?php

namespace App\Models\Core;

use App\Models\Api\Token;
use App\Traits\ErrorsTrait;


/**
 * Class DocumentsInformation
 * @package App\Models\Core
 *
 *
 * @property int $id
 * @property int $token_id
 * @property string $token_generated_date
 * @property string $phone_confirmed_date
 * @property string $signature_date
 * @property $document_sent_date
 * @property string $first_name
 * @property string $last_name
 * @property string $passport
 * @property int $department_id
 * @property int $company_id
 * @property int $insurance_type_id
 * @property int $number_of_policy
 * @property $birth_date
 * @property string $passport_scan
 * @property string $email
 * @property string $phone
 * @property string $street
 * @property string $city
 * @property string $zip_code
 * @property string $house_number
 * @property int $number_of_policyholders
 * @property string $payment_method
 * @property string reason_for_cancellation
 * @property int $signature
 * @property int $pdf_file_id
 * @property int $png_file_id
 * @property $created_at
 * @property $updated_at
 * @property int $confirmed
 * @property int $agent_id
 */
class AgentDocumentsInformation extends AbsModel
{
    use ErrorsTrait;

    protected $table = "agents_documents_information";

    protected $fillable = [
        'token_id',
        'token_generated_date',
        'phone_confirmed_date',
        'signature_date',
        'document_sent_date',
        'first_name',
        'last_name',
        'passport',
        'company_id',
        'department_id',
        'number_of_policy',
        'birth_date',
        'passport_scan',
        'email',
        'phone',
        'street',
        'city',
        'zip_code',
        'house_number',
        'number_of_policyholders',
        'payment_method',
        'reason_for_cancellation',
        'confirmed',
        'agree_the_conditions',
        'signature',
        'pdf_file_id',
        'png_file_id',
        'confirmed',
        'agent_id',
    ];

    protected $validationRules = [
        'token_id' => 'required',
        'first_name' => '',
        'last_name' => '',
        'passport' => '',
        'company_id' => 'numeric',
        'department_id' => 'required_with:company_id|integer',
        'number_of_policy' => 'numeric',
        'birth_date' => 'date',
        'passport_scan' => 'numeric',
        'email' => 'email',
        'phone' => '',
        'street' => '',
        'city' => '',
        'zip_code' => '',
        'house_number' => '',
        'number_of_policyholders' => '',
        'payment_method' => 'numeric',
        'reason_for_cancellation' => 'numeric',
        'confirmed' => 'in:0,1',
        'agree_the_conditions' => 'in:0,1',
        'signature' => 'numeric',
        'pdf_file_id' => 'numeric',
        'png_file_id' => 'numeric',
    ];

    /**
     * @return Token
     */
    public function token()
    {
        return $this->belongsTo(Token::class)->first();
    }

    /**
     * @return User
     */
    public function agent()
    {
        return $this->belongsTo(User::class)->first();
    }

    /**
     * @return Companies
     */
    public function company()
    {
        return $this->belongsTo(Companies::class)->first();
    }

    /**
     * @return Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class)->first();
    }

    /**
     * @return UserInsuranceType
     */
    public function userInsuranceType()
    {
        return $this->belongsTo(UserInsuranceType::class)->first();
    }

    /**
     * @return InsuranceType
     */
    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class)->first();
    }

    /**
     * @return PaymentMethods
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method')->first();
    }

    /**
     * @return ReasonForCancellation
     */
    public function reasonForCancellation()
    {
        return $this->belongsTo(ReasonForCancellation::class, 'reason_for_cancellation')->first();
    }

    /**
     * @return Files
     */
    public function signature()
    {
        return $this->belongsTo(Files::class, 'signature')->first();
    }

    /**
     * @return Files
     */
    public function pdfFile()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files
     */
    public function pngFile()
    {
        return $this->belongsTo(Files::class)->first();
    }

    public static function findByToken($token)
    {
        return
            self::query()
                ->where(['token' => $token])
                ->first();
    }
}
