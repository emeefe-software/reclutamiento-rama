<?php

namespace App\Http\Controllers;

use App\Career;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    private function validator(array $data){
        return Validator::make($data,[
            'inputNameCareer' => 'required',
            'inputWithCV' => 'required',
            'inputWithPortfolio'=>'required'
        ],[
            'inputNameCareer.required' => 'El campo nombre es requerido',
            'inputWithCV.required' => 'El campo CV es requerido',
            'inputWithCV.required' => 'El campo portafolio es requerido'
        ]);
    }

    public function index(){
        return view('careers.index',[
            'authenticatedUser' => Auth::user(),
            'careers'=> Career::orderBy('name')->get(),
        ]);
    }

    public function create(){
        return view('careers.register',
            [
                'authenticatedUser' => Auth::user()
            ]
        );
    }

    public function store(Request $request){
        $this->validator($request->all());
        Career::create([
            'name'=>$request->inputNameCareer,
            'withCV' =>$request->inputWithCV==='1' ? true : false,
            'withPortfolio'=>$request->inputWithPortfolio==='1' ? true : false,
        ]);
        return redirect()->route('careers.index');
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
    public function edit(Career $career)
    {
        return view('careers.edit',[
            'authenticatedUser' => Auth::user(),
            'career'=>$career,
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Career $career)
    {
        $this->validator($request->all());
        $career->name=$request->inputNameCareer;
        $career->withCV=$request->inputWithCV;
        $career->withPortfolio=$request->inputWithPortfolio;
        $career->update();
        return redirect()->route('careers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('careers.index')->with('alert', 'Se eliminó la carrera correctamente');
    }
}
