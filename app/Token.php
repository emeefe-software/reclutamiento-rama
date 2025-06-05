<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'tokens';

    public function scopeValids($query){
        return $query->where('is_valid', true);
    }

    public function scopeToken($query, $token){
        return $query->where('token', $token);
    }
}
