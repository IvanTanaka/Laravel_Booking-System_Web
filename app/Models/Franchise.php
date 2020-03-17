<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Franchise extends Model
{
    //
    protected $table="franchise";
    protected $keyType = 'string';
    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = self::generateUuid();
         });
    }
    public static function generateUuid()
    {
         return Uuid::generate();
    }

    public function branches(){
        return $this->hasMany('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
