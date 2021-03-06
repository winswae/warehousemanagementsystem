<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description', 
        'country',
        'city',
        'address',
        'marla',
        'room',
        'status',
        'renter_id'
    ];

    public $table = "warehouses";

    public function warehouseAds(){
        return $this->hasMany(WarehouseAd::class);
    }

    public function user(){
        return $this->belongsTo('App\User'::class,'renter_id');
    }
}
