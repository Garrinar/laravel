<?php

namespace App\Models\Core;

/**
 * Class PriceOffer
 * @package App\Models\Core
 *
 *
 * @property $id
 * @property $agent_id
 * @property $insurance_program_name
 * @property $number_of_insured_persons
 * @property $beginning_date
 * @property $payment_type
 * @property $exclusions
 * @property $benefits_and_discounts
 * @property $comments_police_content
 * @property $monthly_premium_cost
 * @property $insurance_amount
 * @property $full_name
 * @property $id_number
 * @property $city
 * @property $address
 * @property $telephone
 * @property $mail
 * @property $occupation
 * @property $birth_date
 * @property $insurance_type
 * @property $smoking
 * @property $pdf_file_id
 * @property $png_file_id
 * @property $created_at
 * @property $updated_at
 */
class PriceOffer extends AbsModel
{
    protected $fillable = [
        'agent_id',
        'insurance_program_name',
        'number_of_insured_persons',
        'beginning_date',
        'payment_type',
        'exclusions',
        'benefits_and_discounts',
        'comments_police_content',
        'monthly_premium_cost',
        'insurance_amount',
        'full_name',
        'id_number',
        'city',
        'address',
        'telephone',
        'mail',
        'occupation',
        'birth_date',
        'insurance_type',
        'smoking',
        'pdf_file_id',
        'png_file_id',
    ];

    protected $hidden = [
        'id',
        'agent_id',
        'created_at',
        'updated_at',
    ];


    /**
     * @return User
     */
    public function agent()
    {
        return $this->belongsTo(User::class)->first();
    }

    /**
     * @return PaymentMethods
     */
    public function paymentType()
    {
        return $this->belongsTo(PaymentMethods::class, 'payment_type')->first();
    }

    /**
     * @return InsuranceType
     */
    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type')->first();
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

    public function generateDocuments()
    {
        $pdf = new Pdf();
        $pdf->setContent(view('web.agent.priceoffer.offer', ['offer' => $this])->render());

        if ($this->pdf_file_id) {
            $this->pdfFile()->putContent($pdf->get());
            $this->pngFile()->putContent($pdf->getPng());
        } else {
            $filePDF = Files::put(str_random(8) . '.pdf', $pdf->get());
            $filePNG = Files::put(str_random(8) . '.png', $pdf->getPng());
            $this->pdf_file_id = $filePDF->id;
            $this->png_file_id = $filePNG->id;
        }

        return $this->save();
    }
}
