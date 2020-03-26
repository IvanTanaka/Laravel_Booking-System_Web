<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Franchise extends Model
{
    //
    protected $table="franchise";
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

    public function branches(){
        return $this->hasMany('App\Models\Branch');
    }

    public function menu(){
        return $this->hasMany('App\Models\Menu');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
