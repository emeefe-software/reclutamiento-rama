<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use DateTime;

class Hour extends Model
{
    public const TYPE_SIMULTANEOUS = 'simultaneous';
    public const TYPE_UNIQUE = 'unique';

    protected $fillable=[
        'datetime','end_datetime','type'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'hour_user')
            ->using(ProgramUser::class)
            ->withPivot('interview_id');
    }

    public function date(){
        $date= new DateTime($this->datetime);
        return $date->format('Y-m-d');
    }

    public function dateTime(){
        $date = new DateTime($this->datetime);
        return $date->format('Y-m-d H:i');
    }
    
    public function endDate(){
        $date= new DateTime($this->end_datetime);
        return $date->format('Y-m-d');
    }

    public function MonthAlphabetic(){
        $date = new DateTime($this->datetime);
        return $date->format('M');
    }
    
    public function DayNumeric(){
        $date = new DateTime($this->datetime);
        return $date->format('d');
    }

    public function time(){
        $time= new DateTime($this->datetime);
        return $time->format('H:i');
    }

    public function endTime(){
        $time= new DateTime($this->end_datetime);
        return $time->format('H:i');
    }

    /**
     * Scope para obtener los conflictos de horarios dado un rango, se revisan
     * los siguientes puntos:
     * - Que la fecha de inicio no esté en el rango de inicio y fin de la BD
     * - Que la fecha de fin no esté en el rango de inicio y fin de la BD
     * - Que la fecha de inicio en BD no este en el rango de inicio y fin de argumentos
     * - Que la fecha de fin en BD no este en el rango de inicio y fin de argumentos
     * - Que la fecha de inicio y fin no sean iguales a alguno ya existente y de distinto tipo al que se envia
     * 
     * Uso de rango exclusivo
     */
    public function scopeConflicts($query, Carbon $start, Carbon $end, string $type){
        return $query->where(function($query) use ($start, $end){
            return $query->where('datetime', '>', $start->format('Y-m-d H:i:s'))
                ->where('datetime', '<', $end->format('Y-m-d H:i:s'));
        })->orWhere(function($query) use ($start, $end){
            return $query->where('end_datetime', '>', $start->format('Y-m-d H:i:s'))
                ->where('end_datetime', '<', $end->format('Y-m-d H:i:s'));
        })->orWhere(function($query) use ($start, $end){
            return $query->where('datetime', '<', $start->format('Y-m-d H:i:s'))
                ->where('end_datetime', '>', $start->format('Y-m-d H:i:s'));
        })->orWhere(function($query) use ($start, $end){
            return $query->where('datetime', '<', $end->format('Y-m-d H:i:s'))
                ->where('end_datetime', '>', $end->format('Y-m-d H:i:s'));
        })->orWhere(function($query) use ($start, $end, $type){
            return $query->where('datetime', $start->format('Y-m-d H:i:s'))
                ->where('end_datetime', $end->format('Y-m-d H:i:s'))
                ->where(function($query) use ($type){
                    if($type == self::TYPE_UNIQUE){
                        return $query->where('type', self::TYPE_SIMULTANEOUS);
                    }else{
                        return $query->where('type', self::TYPE_UNIQUE);
                    }
                });
        });
    }

    /**
     * Devolver horarios mayores al día y hora actuales
     */
    public function scopeGreaterThanNow($query){
        return $query->whereDate('datetime','>',now()->toDateTimeString());
    }
}
