<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramUser extends Pivot
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function interview(){
        return $this->belongsTo('App\Interview');
    }
}
