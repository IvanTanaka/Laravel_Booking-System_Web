<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Cashier extends Model
{
    //
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
