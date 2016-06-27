<?php

namespace App\Models\Core;

use App\Models\Api\Token;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class DocumentsInformation
 * @package App\Models\Core
 *
 * @property int $id
 * @property int $token_id
 * @property string $token_generated_date
 * @property string $phone_confirmed_date
 * @property string $signature_date
 * @property int $signature
 * @property $document_sent_date
 * @property string $first_name
 * @property string $last_name
 * @property string $passport
 * @property int $department_id
 * @property int $company_id
 * @property int $insurance_type_id
 * @property int $user_insurance_type_id
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
 * @property int $pdf_file_id
 * @property int $png_file_id
 * @property $created_at
 * @property $updated_at
 * @property int $confirmed
 */
class DocumentsInformation extends AbsModel
{
    protected $table = "documents_information";

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
        'insurance_type_id',
        'user_insurance_type_id',
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
        'png_file_id'
    ];

    /**
     * @return Token|Collection
     */
    public function token()
    {
        return $this->belongsTo(Token::class)->first();
    }

    /**
     * @return Companies|Collection
     */
    public function company()
    {
        return $this->belongsTo(Companies::class)->first();
    }

    /**
     * @return Department|Collection
     */
    public function department()
    {
        return $this->belongsTo(Department::class)->first();
    }

    /**
     * @return InsuranceType|Collection
     */
    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class)->first();
    }

    /**
     * @return UserInsuranceType|Collection
     */
    public function userInsuranceType()
    {
        return $this->belongsTo(UserInsuranceType::class)->first();
    }

    /**
     * @return Files|Collection
     */
    public function passportScan()
    {
        return $this->belongsTo(Files::class, 'passport_scan')->first();
    }

    /**
     * @return PaymentMethods|Collection
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_method')->first();
    }

    /**
     * @return ReasonForCancellation|Collection
     */
    public function reasonForCancellation()
    {
        return $this->belongsTo(ReasonForCancellation::class, 'reason_for_cancellation')->first();
    }

    /**
     * @return Files|Collection
     */
    public function pdfFile()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files|Collection
     */
    public function pngFile()
    {
        return $this->belongsTo(Files::class)->first();
    }

    public function validateInsuranceAccountDetails()
    {
        return true;
    }

    public function validatePersonalDetails()
    {
        return true;
    }

    public function validateAddressFields()
    {
        return true;
    }


    public function validateAdditionalFields()
    {
        return true;
    }
}
