<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'registers';
    protected $fillable = [
        'user_id',
        'start_at',
        'end_at'
    ];

    protected $dates = [
        'end_at',
        'start_at'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
