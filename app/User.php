<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_LOCKED = 'locked';
    public const STATUS_DISABLED = 'disabled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password','first_name','last_name','email','pin','phone','contact_name','contact_phone','address','area','skype'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registers(){
        return $this->hasMany('App\Register');
    }

    public function food_registers(){
        return $this->hasMany('App\FoodRegister');
    }

    public function hours(){
        return $this->belongsToMany(Hour::class,'hour_user');
    }

    public function fullname(){
        return $this->first_name.' '.$this->last_name;
    }

    public function interview(){
        return $this->hasOne(Interview::class);
    }

    public static function getResponsibles(){
        $responsibles=[];
        $users=User::all();
        foreach($users as $user){ 
            if($user->hasRole('responsable'))
                $responsibles[]=$user;
        }
        return $responsibles;
    }
    
    public static function getNotCandidates(){
        $notCandidates=[];
        $users=User::all();
        foreach($users as $user){ 
            if(!$user->hasRole('candidate'))
                $notCandidates[]=$user;
        }
        return $notCandidates;
    }

    public static function getCandidates(){
        return User::whereRoleIs(Role::ROLE_CANDIDATE)->with('interview')->get();
    }
    
    public function scopeCandidates($query){
        return $query->whereRoleIs(Role::ROLE_CANDIDATE);
    }

    public function scopeNoCandidates($query){
        return $query->whereDoesntHave('roles', function($query){
            $query->where('name', Role::ROLE_CANDIDATE);
        });
    }

    public function scopeByStatus($query, $statusType){
        return $query->where('status', $statusType);
    }
}
