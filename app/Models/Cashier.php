<?php

namespace App\Models;

use function App\Helpers\generateUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cashier extends Authenticatable
{
    //
    use Notifiable;

    protected $table = "cashier";
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


    public function franchise()
    {
        return $this->belongsTo('App\Models\Franchise');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
}
