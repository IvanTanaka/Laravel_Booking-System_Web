<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Category extends Model
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
        return $this->hasMany('App\Models\Franchise');
    }
}
