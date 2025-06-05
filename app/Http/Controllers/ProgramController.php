<?php

namespace App\Http\Controllers;

use App\Career;
use App\User;
use App\Program;
use App\Role;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use UxWeb\SweetAlert\SweetAlert as SweetAlertSweetAlert;

class ProgramController extends Controller
{
    private function validator(array $data){
        return Validator::make($data,[
            'folio' => 'required',
            'name' => 'required',
            'university' => 'required',
            'description' => 'required',
            'places' => 'required',
            'careerCheck'=> 'required',
        ],[
            'folio.required' => 'El campo folio es requerido',
            'name.required' => 'El campo es nombre requerido',
            'university.required' => 'El campo es university requerido',
            'description.required' => 'El campo description es requerido',
            'places.required' => 'El campo places es requerido',
            'careerCheck.required' => 'El campo carrera es requerido'
        ]);
    }
    public function index(Request $request){
        return view('programs.index',[
            'programs'=> Program::with('careers')->orderBy('name')->get(),
        ]);
    }

    public function create(){
        return view('programs.register',[
            'universities' => University::all(),
            'careers' => Career::all(),
        ]);
    }

    public function store(Request $request){
        $this->validator($request->all());
        $program=Program::create([
            'folio' => $request->folio,
            'name' => $request->name,
            'university_id' => $request->university,
            'description' => $request->description
        ]);
        
        return redirect()->route('programs.index');
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
    public function edit(Program $program)
    {
        return view('programs.edit',[
            'program'=>$program,
            'universities' => University::all(),
            'responsibles' => User::getResponsibles(),
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $this->validator($request->all());
        $program->folio=$request->folio;
        $program->name=$request->name;
        $program->university_id=$request->university;
        $program->description=$request->description;
        $program->update();
        return redirect()->route('programs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        if($program->careers->isEmpty()){
            $program->delete();
            alert()->success('Se eliminó el programa corretamente','Programa eliminado');
        }else{
            alert()->error('Debes eliminar todas las asociaciones antes','Ocurrió un error');
        }
        return redirect()->route('programs.index');
    }

    public function asociate(){
        return view('programs.asociate',[
            'programs'=>Program::get(),
            'careers' => Career::get(),
            'responsables' => User::whereRoleIs(Role::ROLE_RESPONSABLE)->get(),
        ]); 
    }

    public function asociateStore(Request $request){
        $program = Program::find($request->program);

        try {
            $program->careers()->attach($request->career, [
                'responsable_id' => $request->responsable,
                'places' => $request->places
            ]);
            alert()->success('Asociación creada correctamente','Asociación creada');
        } catch (\Throwable $th) {
            alert()->error('Puede que la asociación ya exista', 'Ocurrió un error');
            return redirect()->route('programs.index');
        }
        

        return redirect()->route('programs.index');
    }

    public function asociateEdit(Request $request){
        return view('programs.asociate_edit',[
            'program'=>Program::find($request->program_id),
            'careerUpdate'=>Career::find($request->career_id),
            'responsableUpdate'=>User::find($request->responsable_id),
            'careers' => Career::get(),
            'responsables' => User::whereRoleIs(Role::ROLE_RESPONSABLE)->get(),
        ]);
    }

    public function asociateUpdate(Request $request){
        $program=Program::find($request->program_id);
        try {
            $program->careers()->detach($request->careerOld);
            $program->careers()->attach($request->career, [
                'responsable_id' => $request->responsable,
                'places' => $request->places
            ]);
            alert()->success('Asociación actualizada correctamente','Asociación actualizada');
        } catch (\Throwable $th) {
            alert()->error('Puede que la asociación ya exista', 'Ocurrió un error');
            return redirect()->route('programs.index');
        }

        return redirect()->route('programs.index');
    }

    public function asociateDestroy(Request $request){
        $program=Program::find($request->program_id);
        try {
            $program->careers()->detach($request->career_id);
            alert()->success('Se eliminó la asociación corretamente','Asociación eliminada');
        } catch (\Throwable $th) {
            alert()->error('Puede que la asociación no exista', 'Ocurrió un error');
            return redirect()->route('programs.index');
        }
        return redirect()->route('programs.index');
    }

    public function isPaused(Request $request, Program $program){
        
        if($request->pausar){
            $program->is_paused = true;
            $program->save();
            alert()->success('El programa fué pausado exitósamente','Programa pausado');
        }else{
            $program->is_paused = false;
            $program->save();
            alert()->success('El programa fué reanudado exitósamente','Programa reanudado');
        }

        return redirect()->route('programs.index');
    }
}

