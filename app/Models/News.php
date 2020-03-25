<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class News extends Model
{
    //
    protected $table = "news";
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

    public function franchise()
    {
        return $this->belongsTo('App\Models\Franchise');
    }
}