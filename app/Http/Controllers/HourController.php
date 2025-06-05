<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hour;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HourController extends Controller
{
    private function validator(array $data){
        return Validator::make($data,[
            'date' => ['required'],
            'time' => ['required'],
            'end_time' => ['required'],
            'responsibleCheck' => ['required'],
            'typeRadio' => ['required'],
        ],[
            'date.required' => 'El campo fecha es requerido',
            'time.required' => 'El campo hora es requerido',
            'end_time.required' => 'El campo hora de finalización es requerido',
            'responsibleCheck.required' => 'El campo responsable es requerido',
            'typeRadio.required' => 'El campo tipo es requerido',
        ]);
    }

    public function index(){
        return view('hours.index',[
            'hours'=>Hour::greaterThanNow()->orderBy('datetime')->get()
        ]);
    }

/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hours.register',[
            'responsibles'=> User::getResponsibles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all());

        DB::beginTransaction();
        try {
            $type = $request->typeRadio==0 ? 'simultaneous' : 'unique';
            $startDate = Carbon::createFromFormat('Y-m-d H:i', $request->date.' '.$request->time);
            $endDate = Carbon::createFromFormat('Y-m-d H:i', $request->end_date.' '.$request->end_time);
            $errors = [];

            while($startDate->lessThan($endDate)){
                $endInSameDay = Carbon::createFromFormat('Y-m-d H:i', $startDate->format('Y-m-d').' '.$request->end_time);
                $hasConflicts = Hour::conflicts(
                    $startDate,
                    $endInSameDay,
                    $type
                )->exists();
    
                if($hasConflicts){
                    $errors[] = 'Hay conflictos con el horario '.$startDate->format('Y-m-d H:i').' - '.$endInSameDay->format('Y-m-d H:i');
                    $startDate->addDay();
                    continue;
                }
                
                foreach($request->responsibleCheck as $responsibleId){
                    
                    $user = User::find($responsibleId);
    
                    if(!$hasConflicts){
                        $hour = Hour::firstOrCreate([
                            'datetime'=>$startDate->format('Y-m-d H:i:s'),
                            'end_datetime'=>$endInSameDay->format('Y-m-d H:i:s'),
                            'type'=> $type,
                        ]);
    
                        try {
                            $user->hours()->attach($hour->id);
                        } catch (\Throwable $th) {
                            $errors[] = 'Conflicto con '.$user->first_name.', el horario ya está relacionado';
                        }
                    }
                }

                $startDate->addDay();
            }
    
            if(count($errors) > 0){
                alert()->warning(implode('<br>', $errors), 'Hubo conflictos')->html()->persistent('Cerrar');
            }else{
                alert()->success('Horario(s) guardado(s) corrécatmente');
            }
            
            DB::commit();
            return redirect()->route('hours.index');   
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            alert()->error('Ocurrió un error');
            return redirect()->back(); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hour $user)
    {
        return view('users.edit',[
            'user'=>$user
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Hour $user)
    {
        $this->validator($request->all());
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->email=$request->email;
        $user->pin=$request->pin;
        $user->area=$request->area;
        $user->update();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Hour $hour)
    {
        $hour->users()->detach($request->user);
        if(!$hour->users()->count()){
            $hour->delete();
        }
        
        return redirect()->route('hours.index');
    }
}
