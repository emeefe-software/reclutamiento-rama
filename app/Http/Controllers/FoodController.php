<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Token;
use App\FoodRegister;
use DB;
use Auth;
use Carbon\Carbon;

class FoodController extends Controller
{
    private const MAX_HOUR = 10;

    function __construct(){
    }

    public function food(Request $request){
        $user = User::whereNotNull('pin')->where('pin',$request->pin)->first();
        $token = $request->header('X-Token');

        if(!($token && Token::valids()->token($token)->count())){
            return Response::json([
                'msg'=>'No autorizado',
            ], 403);
        }

        if(!$user){
            return Response::json([
                'msg' => 'El PIN no existe'
            ], 404);
        }

        $existsFoodRegister = $user->food_registers()->date(now())->count();

        if($existsFoodRegister){
            return Response::json([
                'msg' => 'Ya confirmaste',
                'type' => 'food_confirm_exists'
            ]);
        }

        /*$register = new FoodRegister();
        $register->date = now();
        $register->user_id = $user->id;
        $register->save();*/

        return Response::json([
            'msg' => 'Debes confirmar desde http://checador.emeefe.mx',
            'type' => 'food_confirm',
        ]);
    }

    public function pay(Request $request, FoodRegister $food){
        $food->payed_at = now();
        $food->payment = 30;
        $food->save();

        return Response::json([
            'msg' => 'Pagado',
            'type' => 'food_payment_success',
        ]);
    }

    public function index(){
        $foods = FoodRegister::select(DB::raw('count(*) as total, date'))
            ->groupBy('date')
            ->orderBy('date','desc')
            ->get();

        return view('foods_index', [
            'foods'=>$foods,
            'user'=>Auth::user()
        ]);
    }

    public function askConfirm(){
        $date = now();
        $user = Auth::user();
        $is_now = false;
        $is_monday = false;

        if( ($date->dayOfWeek == Carbon::FRIDAY && $date->hour >= self::MAX_HOUR) ||
            in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])){
            $date = new Carbon('next monday');
            $is_monday = true;
        }elseif($date->hour < self::MAX_HOUR){
            $date->hour = self::MAX_HOUR;
            $is_now = true;
        }else{
            $date->addDay();
            $date->hour = self::MAX_HOUR;
        }

        $existsFoodRegister = $user->food_registers()->date($date)->count();
        
        return view('foods_ask_confirm',[
            'is_confirmed' => $existsFoodRegister,
            'is_now' => $is_now,
            'is_monday' => $is_monday,
            'debts' => FoodRegister::where('user_id', $user->id)
                ->whereNull('payed_at')->get()
        ]);
    }

    public function confirm(){
        $date = now();
        $user = Auth::user();

        if( ($date->dayOfWeek == Carbon::FRIDAY && $date->hour >= self::MAX_HOUR) ||
            in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])){
            $date = new Carbon('next monday');
        }elseif($date->hour < self::MAX_HOUR){
            $date->hour = self::MAX_HOUR;
        }else{
            $date->addDay();
            $date->hour = self::MAX_HOUR;
        }

        $existsFoodRegister = $user->food_registers()->date($date)->count();

        if($existsFoodRegister){
            return Response::json([
                'msg' => 'Ya confirmaste',
                'type' => 'food_confirm_exists'
            ]);
        }

        $register = new FoodRegister();
        $register->date = $date;
        $register->user_id = $user->id;
        $register->save();

        return Response::json([
            'msg' => 'Has confirmado',
            'type' => 'food_confirm',
        ]);
    }

    public function comidas(){
        $foods = FoodRegister::select(DB::raw('count(*) as total, date'))
            ->groupBy('date')
            ->orderBy('date','desc')
            ->get();

        return view('comidas', [
            'foods'=>$foods,
        ]);
    }
}
