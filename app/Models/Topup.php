<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Topup extends Model
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

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
