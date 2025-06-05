<?php

namespace App;

use App\Career;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    
    protected $fillable=[
        'name','folio','university_id','description','places'
    ];

    protected $casts = [
        'is_paused' => 'boolean',
    ];

    public function university(){
        return $this->belongsTo(University::class,'university_id');
    }

    public function careers(){
        return $this->belongsToMany(Career::class, 'program_career')
            ->withPivot('places', 'responsable_id');
    }

}
