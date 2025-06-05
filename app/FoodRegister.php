<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodRegister extends Model
{
    protected $table ='food_registers';

    protected $dates = [
        'date'
    ];


    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * Scope para devolver por fecha
     * 
     * @param $query Builder
     * @param $date  Carbon\Carbon
     */
    public function scopeDate($query, $date){
        return $query->where('date',$date->format('Y-m-d'));
    }
}
