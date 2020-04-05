<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use function App\Helpers\generateUuid;

class Customer extends Authenticatable
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;
    protected $fillable = [
        'name', 'email', 'password','phone_number', "api_token"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $keyType = 'string';
    
    public static function boot()
    {
         parent::boot();
         self::creating(function($model){
             $model->id = generateUuid();
         });
    }

}
