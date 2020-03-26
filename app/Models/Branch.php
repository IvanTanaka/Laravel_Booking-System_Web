<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\generateUuid;

class Branch extends Model
{
    //
    protected $table = "branch";
    protected $primaryKey ="id";
    public $incrementing = false;
    protected $keyType = 'string';
    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = generateUuid();
         });

        self::deleting(function($model) {
            $relationMethods = ['cashiers'];

            foreach ($relationMethods as $relationMethod) {
                if ($model->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }


    public function franchise()
    {
        return $this->belongsTo('App\Models\Franchise');
    }

    public function cashiers()
    {
        return $this->hasMany('App\Models\Cashier');
    }
}
