<?php namespace App\Models\Core;


/**
 * Class Users
 * @package App
 */
class ActionHistory extends AbsModel
{
    const
        STATUS_SENT_FOR_SIGNATURE = 1,
        STATUS_IN_PROCESS = 2,
        STATUS_SUCCESS = 3,
        STATUS_PROBLEM = 4,

        TYPE_POLIS_CANCELLATION = 1,
        TYPE_SENDING_FAX_EMAIL = 2,
        TYPE_SENDING_DOC_FOR_SIGNATURE = 3,
        TYPE_SENDING_PRICE_OFFER = 4;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'action_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'document_id',
        'receiver_name',
        'type',
        'created_at'
    ];

    protected $hidden = [
        'user_id',
        'updated_at'
    ];
}