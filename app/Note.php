<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Interview;
use DateTime;

class Note extends Model
{
    protected $fillable=[
        'note'
    ];

    public function anotable(){
        return $this->morphTo();
    }

    public function date(){
        $date= new DateTime($this->created_at);
        return $date->format('Y-m-d');
    }

}
