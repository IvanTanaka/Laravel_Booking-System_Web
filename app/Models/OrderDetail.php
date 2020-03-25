<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class OrderDetail extends Model
{
    //
    protected $table = "order";
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

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu');
    }
}
