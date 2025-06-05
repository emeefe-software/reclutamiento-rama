<?php

namespace App;
use App\Hour;
use App\Program;
use App\Note;
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use SoftDeletes;
    
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_UNREALIZED = 'unrealized';
    public const STATUS_DONE_CHECKING = 'done-checking';
    public const STATUS_DONE_ACCEPTED = 'done-accepted';
    public const STATUS_DONE_REJECTED = 'done-rejected';
    public const STATUS_DONE_ENROLLED = 'done-enrolled';

    protected $fillable=[
        'status','program_id','career_id','user_id','CV','portfolio'
    ];

    public function program(){
        return $this->belongsTo(Program::class,'program_id');
    }

    public function career(){
        return $this->belongsTo(Career::class,'career_id');
    }

    public function hour(){
        return $this->belongsToMany(Hour::class,'hour_user');
    }

    public function candidate(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function anotable(){
        return $this->morphMany(Note::class,'anotable');
    }

    public function getStatus():String{
        switch($this->status){
            case self::STATUS_SCHEDULED: return 'Agendada'; 
            case self::STATUS_UNREALIZED: return 'No realizada'; 
            case self::STATUS_DONE_ACCEPTED: return 'Realizada (aceptado)'; 
            case self::STATUS_DONE_CHECKING: return 'Realizada (evaluando)'; 
            case self::STATUS_DONE_REJECTED: return 'Realizada (rechazado)'; 
            case self::STATUS_DONE_ENROLLED: return 'Realizada (inscrito)'; 
        }
    }

    public function getAllStatus(){
        return [
            self::STATUS_SCHEDULED => 'Agendada', 
            self::STATUS_UNREALIZED => 'No realizada', 
            self::STATUS_DONE_ACCEPTED => 'Realizada (aceptado)', 
            self::STATUS_DONE_CHECKING => 'Realizada (evaluando)', 
            self::STATUS_DONE_REJECTED => 'Realizada (rechazado)', 
            self::STATUS_DONE_ENROLLED => 'Realizada (inscrito)',
        ];
    }

    public function setStatus(String $status):void{
        switch($status){
            case 'Agendada': 
                $this->status=self::STATUS_SCHEDULED;
                break;
            case 'No realizada': 
                $this->status=self::STATUS_UNREALIZED;
                break;
            case 'Realizada (aceptado)': 
                $this->status=self::STATUS_DONE_ACCEPTED;
                break;
            case 'Realizada (evaluando)': 
                $this->status=self::STATUS_DONE_CHECKING;
                break;
            case 'Realizada (rechazado)': 
                $this->status=self::STATUS_DONE_REJECTED;
                break;
            case 'Realizada (inscrito)': 
                $this->status=self::STATUS_DONE_ENROLLED;
                break;
        }
    }
    
    public function scopePendingInterviews($query){
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    public function scopePendingInterviewsByResponsable($query, $userID){
        $career = Career::whereHas('responsable_id', $userID)->get();
        $program = Program::whereHas('responsable_id', $userID)->get();

        return $query->where('status', self::STATUS_SCHEDULED)
                    ->where('program_id', $program->id)
                    ->where('career_id', $career->id);
    }

}
