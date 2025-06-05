<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    private function validator(array $data){
        return Validator::make($data,[
            'inputNameUniversity' => 'required',
            'inputDescription' => 'required',
            'inputShortName' => 'required'
        ],[
            'inputNameUniversity.required' => 'El campo nombre es requerido',
            'inputDescription.required' => 'El campo descripción es requerido',
            'inputShortName.required' => 'El campo abreviatura es requerido'
        ]);
    }

    public function index(){
        return view('universities.index',[
            'universities' => University::orderBy('name')->get()
        ]);
    }

    public function create(){
        return view('universities.register');
    }

    public function store(Request $request){
        $this->validator($request->all());
        University::create([
            'name'=>$request->inputNameUniversity,
            'description' => $request->inputDescription,
            'shortName' => $request->inputShortName
        ]);
        return redirect()->route('universities.index');
    }

    public function edit(University $university){
        return view('universities.edit',[
            'university'=>$university
        ]);
    }

    public function update(Request $request,University $university){
        $this->validator($request->all());
        $university->name=$request->inputNameUniversity;
        $university->description=$request->inputDescription;
        $university->shortName=$request->inputShortName;
        $university->update();
        return redirect()->route('universities.index');
    }

    public function destroy(University $university){
        $university->delete();
        return redirect()->route('universities.index');
    }

}
