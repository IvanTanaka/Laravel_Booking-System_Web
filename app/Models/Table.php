<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    protected $fillable = ['number','size','branch_id'];
    protected $dates = ['deleted_at'];
    use SoftDeletes;

    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }


}
