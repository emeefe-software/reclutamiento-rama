<?php

namespace App;

use App\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use SoftDeletes;

    protected $hidden = ['pivot'];

    protected $casts = [
        'withCV' => 'boolean',
        'withPortfolio' => 'boolean',
    ];

    protected $fillable=[
        'name','withCV','withPortfolio'
    ];

    public function programs(){
        return $this->belongsToMany(Program::class,'program_career')
            ->withPivot('responsable_id', 'places');
    }
}
