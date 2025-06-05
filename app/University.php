<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name','description','shortName'
    ];

    public function programs(){
        return $this->hasMany(Program::class);
    }
}
