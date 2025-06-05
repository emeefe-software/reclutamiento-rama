<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Register;
use App\Token;
use Response;

class RegisterController extends Controller
{

    public function check(Request $request){
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

        $openRegister = $user->registers()->whereNull('end_at')->first();

        if($openRegister){
            $end = now();
            $openRegister->end_at = $end;
            $openRegister->save();

            $minutes = $end->diffInMinutes($openRegister->start_at);
            $hours = (int)($minutes/60);
            $minutes = $minutes - $hours*60;

            return Response::json([
                'msg' => 'Checkout registrado',
                'type' => 'out',
                'time' => str_pad($hours,2,'0',STR_PAD_LEFT).":".str_pad($minutes,2,'0',STR_PAD_LEFT). " hrs",
                'name' => $user->fullname()
            ]);
        }

        $register = new Register();
        $register->start_at = now();
        $register->user_id = $user->id;
        $register->save();

        return Response::json([
            'msg' => 'Checkin registrado',
            'type' => 'in',
            'time' => null,
            'name' => $user->fullname()
        ]);
    }

    public function index(Request $request, User $user){
        return view('registers_index', [
            'registers'=>$user->registers()->orderBy('start_at')->get(),
            'user'=>$user
        ]);
    }

    public function store(Request $request){
        Register::create([
            'user_id' => $request->user_id,
            'start_at' => Carbon::parse($request->start_at),
            'end_at' => Carbon::parse($request->end_at)
        ]);
        return response()->json(['title' => 'creado', 'description' => 'Registro creado correctamente']);
    }

    public function destroy($id){
        Register::destroy($id);
        return response()->json(["tittle" => "eliminado", "description" => "Registro eliminado correctamente"]);
    }

    public function update(Request $request, $id){
        $register = Register::find($id);
        $register->start_at = Carbon::parse($request->start_at);
        $register->end_at = Carbon::parse($request->end_at);
        $register->save();
        return response()->json(['title' => 'actualizado', 'description' => 'Registro actualizado correctamente']);
    }
}
