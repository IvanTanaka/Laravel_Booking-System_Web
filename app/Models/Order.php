<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Order extends Model
{
    //
    protected $primaryKey ="id";
    public $incrementing = false;
    protected $keyType = 'string';
    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = generateUuid();
         });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function rate()
    {
        return $this->hasOne('App\Models\Rate');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function cashier()
    {
        return $this->belongsTo('App\Models\Cashier');
    }

    public function franchise()
    {
        return $this->belongsTo('App\Models\Franchise');
    }
}
