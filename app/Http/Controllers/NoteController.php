<?php

namespace App\Http\Controllers;

use App\Interview;
use App\Note;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'inputNote'=>'required'
        ],[
            'inputNote.required'=> 'El campo nota es requerido'
        ]);
        $interview=Interview::find($request->idInterview);
        $record=new Record();
        $note=new Note();
        DB::beginTransaction();
        try{
            $user=Auth::user();
            $note->note=$request->inputNote;
            $note->anotable_type=Interview::class;
            $note->anotable_id=$interview->id;
            $note->user_id=$user->id;
            $note->save();
            $record->summary="Se agregó una nota por: ".$user->fullname();
            $record->model_type=Interview::class;
            $record->model_id=$interview->id;
            $record->save();
            DB::commit();
        }catch(\Throwable $th){
            DB::rollBack();
        }
        alert()->success('Se agregó una nota nueva','Nueva Nota');
        return redirect()->route('interviews.show',[
            'interview'=>$interview
        ]);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
