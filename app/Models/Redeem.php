<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Redeem extends Model
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

    public function franchise(){
        return $this->belongsTo('App\Models\Franchise');
    }

    public function owner(){
        return $this->belongsTo('App\Models\Owner');
    }

    public function bank_account(){
        return $this->belongsTo('App\Models\BankAccount');
    }
}
