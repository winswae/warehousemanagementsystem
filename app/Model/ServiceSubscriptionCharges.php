<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceSubscriptionCharges extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'renter_id', 
        'month', 
        'service_id',
        'payment_status',
        'account_number',
        'system_verification',
        'paid_at',
    ];

    public $table = "service_subscription_charges";
}
