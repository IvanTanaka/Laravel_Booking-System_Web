<?php

namespace App\Observers;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

class TableObserver
{
    public function creating(Table $table){
        $table->created_by = Auth::id();
        $table->updated_by = Auth::id();
    }

    public function updating(Table $table){
        $table->updated_by = Auth::id();
    }
}
