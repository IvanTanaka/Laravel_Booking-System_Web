<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Franchise extends Model
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

    public function branches(){
        return $this->hasMany('App\Models\Branch');
    }

    public function menus(){
        return $this->hasMany('App\Models\Menu');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function redeems()
    {
        return $this->hasMany('App\Models\Redeem');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner');
    }
}
