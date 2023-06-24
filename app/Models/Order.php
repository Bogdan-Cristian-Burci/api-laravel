<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{

    /*
     * Netopia statuses received after sending a payment request
     * */
    const  STATUS =[
            'NEW'=>'new',
            'CONFIRMED'=>'confirmed/captured',
            'CONFIRMED_PENDING'=>'pending',
            'PAID_PENDING'=>'pending',
            'PAID'=>'open/preauthorized',
            'CANCELED'=>'canceled',
            'CREDIT'=>'refunded',
            'REJECTED'=>'rejected'
        ];
    protected $fillable = [
        'payment_id',
        'user_id',
        'amount',
        'status',
    ];

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'order_training');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
