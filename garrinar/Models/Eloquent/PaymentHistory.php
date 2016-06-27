<?php namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * Class Users
 * @package App
 */
class PaymentHistory extends AbsModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'payment_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_id',
        'user_id',
        'price',
        'invoice_id',
        'invoice_pdf',
        'updated_at',
        'created_at'
    ];
    
    public static function getPaymentHistory($user_id = null){
        $query = DB::table('payment_history AS ph')
            ->select('ph.created_at AS date','ph.price','ph.invoice_id','ph.invoice_pdf', 'pt.name AS package_name')
            ->leftJoin('package_types AS pt', 'ph.package_id', '=', 'pt.id');
        
        if(!empty($user_id)){
            $query->where('ph.user_id', '=', $user_id);
        }
        return $query->get();
    }
}