<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Career;
use App\Program;
use App\User;
use App\University;
use App\Hour;
use App\Interview;
use App\Library\Recaptcha;
use App\Mail\ScheduledInterview;
use App\Note;
use App\Record;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class InterviewController extends Controller
{
    public function scheduleByGuest(){

        $universitiesTemp = University::select('id', 'name')->with(['programs'=> function($q){
            $q->select('university_id', 'id', 'name')
            ->where('is_paused', 0)
            ->with(['careers' => function($q){
                $q->select('career_id');
            }]);
        }])->get();

        /**
         * !se trato de implementar una manera diferente de obtener los id's de las carreras como una arreglo
         */
        // $universities = $universities->map(function($university){
        //     $university['programs'] = $university['programs']->map(function($program){
        //         $program['careers'] = $program['careers']->pluck('career_id');
        //         return $program['careers'];
        //     });
        //     return $university;
        // });
        
        $universities = [];
        foreach($universitiesTemp as $universityTemp){
            $programsTemp = $universityTemp['programs'];
            $programs = [];
            foreach($programsTemp as $programTemp){
                $carrers = $programTemp['careers']->pluck('career_id');
                $program = [
                    'id' => $programTemp['id'],
                    'name' => $programTemp['name'],
                    'careers' => $carrers,
                ];
                $programs[] = $program;
            }
            $university = [
                'id' => $universityTemp['id'],
                'name' => $universityTemp['name'],
                'programs' => $programs,
            ];
            $universities[] = $university;
        }

        return view('interviews.schedule', [
            'universities' => $universities,
            'careers' => Career::select('id', 'name', 'withCV', 'withPortfolio')->get(),
        ]);
    }

    public function scheduleByResponsable(){
        $universities = [];
        foreach(University::with('programs')->get() as $university){
            $universityData = [
                'id' => $university->id,
                'name' => $university->name,
                'programs' => []
            ];

            foreach ($university->programs as $program) {
                $universityData['programs'][] = [
                    'id' => $program->id,
                    'name' => $program->name,
                    'careers' => $program->careers->pluck('id')->toArray()
                ];
            }

            $universities[] = $universityData;
        }
        return view('interviews.register', [
            'universities' => $universities,
            'careers' => Career::select('id', 'name', 'withCV', 'withPortfolio')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('interviews.index',[
            'interviews'=>Interview::with('hour')->get()->sortByDesc(function($interview){
                return Carbon::parse($interview->hour->first()->datetime)->timestamp;
            })
        ]);
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
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|min:10|max:10',
            'hour'=> $request->selectHour==0 ? 'required|exists:hours,id' : '',
            'career'=>'required|exists:careers,id',
            'program'=>'required|exists:programs,id',
            'university'=>'required|exists:universities,id',
            'message'=>'nullable',
            'cv'=>'nullable|mimetypes:application/pdf',
            'portfolio'=>'nullable|mimetypes:application/pdf',
            'skype'=>'required',
            'date' => $request->selectHour==1 ? 'required' : '',
            'time' => $request->selectHour==1 ? 'required' : '',
            'end_time' => $request->selectHour==1 ? 'required' : '',
        ],[
            'name.required'=>'El campo nombre es requerido',
            'last_name.required'=>'El campo apellido es requerido',
            'email.required'=>'El campo email es requerido',
            'email.email'=>'El campo email no tiene el formato permitido',
            'email.unique'=>'El email ya está registrado, por favor coloca uno distinto',
            'phone.required'=>'El campo teléfono es requerido',
            'phone.min'=>'El teléfono no cumple con la longitud permitida',
            'phone.max'=>'El teléfono no cumple con la longitud permitida',
            'hour.required'=>'El horario es requerido',
            'hour.exists'=>'El horario no existe',
            'career.required'=>'El campo carrera es requerido',
            'career.exists'=>'La carrera no existe',
            'university.required'=>'El campo universidad es requerido',
            'university.exists'=>'La universidad no existe',
            'program.required'=>'El campo programa es requerido',
            'skype.required'=>'La cuenta de skype es requerida',
            'cv.mimetypes'=>'El CV debe estar en formato PDF',
            'portfolio.mimetypes'=>'El portafolio debe estar en formato PDF',
            'date.required' => 'La fecha es requerida',
            'time.required' => 'La hora de inicio es requerida',
            'end_time.required' => 'La hora final es requerida', 
        ]);

        DB::beginTransaction();
        try {
            if($request->selectHour==0){
                $hour_id=$request->hour;
                $hour = Hour::find($request->hour);
            }
            else{
                $user=Auth::user();
                $hour=new Hour();
                $hour->datetime=$request->date.' '.$request->time;
                $hour->end_datetime=$request->date.' '.$request->end_time;
                $hour->type='unique';
                $hour->save();
                $user->hours()->attach($hour->id);
                $hour_id=$hour->id;
            }
    
            if(!$this->getAvailableHours($request->career, $request->program)->contains('id', $hour_id)){
                DB::rollBack();
                return Response::json([
                    'msg' => 'El horario no está disponible'
                ], 409);
            }
        } catch (\Throwable $th) {
            info([$request, $th->getMessage()]);
            DB::rollBack();
            return Response::json([
                'msg' => 'Ocurrió un error'
            ], 409);
        }

        if(!Recaptcha::validateToken($request['g-recaptcha-response'] ? : '')){
            DB::rollBack();
            return Response::json([
                'msg' => 'El captcha no es válido'
            ], 409);
        }

        try {
            $career = Career::find($request->career);
            $program = $career->programs()->find($request->program);
            $responsable = User::find($program->pivot->responsable_id);


            $user=User::create([
                'password' => Hash::make('pass-'.rand(1000,2000)),
                'first_name'=>$request->name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'area'=>$career->name,
                'skype'=>$request->skype
            ]);
            $user->attachRole(Role::ROLE_CANDIDATE);

            $pathCV = null;
            $pathPortfolio = null;

            if($request->cv){
                $pathCV = $request->file('cv')->storeAs('cv', 'cv_'.$user->email);
            }

            if($request->portfolio){
                $pathPortfolio = $request->file('portfolio')->storeAs('portfolio', 'portfolio_'.$user->email);
            }
            
            $interview=Interview::create([
                'status'=>Interview::STATUS_SCHEDULED,
                'program_id'=>$request->program,
                'career_id'=>$request->career,
                'user_id'=>$user->id,
                'CV'=> $pathCV,
                'portfolio'=> $pathPortfolio,
            ]);

            $responsable->hours()->updateExistingPivot($hour_id, [
                'interview_id' => $interview->id
            ]);

            if($hour->type == Hour::TYPE_UNIQUE){
                DB::table('hour_user')->where('hour_id', $hour->id)
                    ->where('user_id', '<>', $responsable->id)
                    ->delete();
            }


            $record=new Record();
            $record->summary="Se agendó la entrevista";
            $record->model_type=Interview::class;
            $record->model_id=$interview->id;
            $record->save();

            DB::commit();
        } catch (\Throwable $th) {
            info([$request, $th->getMessage()]);
            DB::rollBack();
            return Response::json([
                'msg' => 'Ocurrió un error'
            ], 409);
        }

        try {
            Mail::to($responsable)->send(new ScheduledInterview($user, $career, $program, $interview, route('interviews.show', ['interview' => $interview->id])));
        } catch (\Throwable $th) {}
        
        return Response::json([
            'msg' => 'Entrevista agendada con éxito'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'nullable|min:10|max:10',
            'hour'=> $request->selectHour==0 ? 'required|exists:hours,id' : '',
            'career'=>'required|exists:careers,id',
            'program'=>'required|exists:programs,id',
            'university'=>'required|exists:universities,id',
            'message'=>'nullable',
            'cv'=>'sometimes|mimetypes:application/pdf',
            'portfolio'=>'sometimes|mimetypes:application/pdf',
            'skype'=>'nullable',
            'date' => $request->selectHour==1 ? 'required' : '',
            'time' => $request->selectHour==1 ? 'required' : '',
            'end_time' => $request->selectHour==1 ? 'required' : '',
        ],[
            'name.required'=>'El campo nombre es requerido',
            'last_name.required'=>'El campo apellido es requerido',
            'email.required'=>'El campo email es requerido',
            'email.email'=>'El campo email no tiene el formato permitido',
            'email.unique'=>'El email ya está registrado, por favor coloca uno distinto',
            'phone.required'=>'El campo teléfono es requerido',
            'phone.min'=>'El teléfono no cumple con la longitud permitida',
            'phone.max'=>'El teléfono no cumple con la longitud permitida',
            'hour.required'=>'El horario es requerido',
            'hour.exists'=>'El horario no existe',
            'career.required'=>'El campo carrera es requerido',
            'career.exists'=>'La carrera no existe',
            'university.required'=>'El campo universidad es requerido',
            'university.exists'=>'La universidad no existe',
            'program.required'=>'El campo programa es requerido',
            'cv.mimetypes'=>'El CV debe estar en formato PDF',
            'portfolio.mimetypes'=>'El portafolio debe estar en formato PDF',
            'date.required' => 'La fecha es requerida',
            'time.required' => 'La hora de inicio es requerida',
            'end_time.required' => 'La hora final es requerida', 
        ]);

        DB::beginTransaction();
        try {
            $career = Career::find($request->career);
            $program = $career->programs()->find($request->program);
            $responsable = User::find($program->pivot->responsable_id);

            if($request->selectHour==0){
                $hour_id=$request->hour;
                $hour = Hour::find($request->hour);

                if(!$this->getAvailableHours($request->career, $request->program)->contains('id', $hour_id)){
                    return Response::json([
                        'msg' => 'El horario no está disponible'
                    ], 409);
                }
            }
            else{
                $hour=new Hour();
                $hour->datetime=$request->date.' '.$request->time;
                $hour->end_datetime=$request->date.' '.$request->end_time;
                $hour->type='unique';
                $hour->save();
                $responsable->hours()->attach($hour->id);
                $hour_id=$hour->id;
            }

            $user=User::create([
                'password' => Hash::make('pass-'.rand(1000,2000)),
                'first_name'=>$request->name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'area'=>$career->name,
                'skype'=>$request->skype
            ]);
            $user->attachRole(Role::ROLE_CANDIDATE);

            $pathCV = null;
            $pathPortfolio = null;

            if($request->cv){
                $pathCV = $request->file('cv')->storeAs('cv', 'cv_'.$user->email);
            }

            if($request->portfolio){
                $pathPortfolio = $request->file('portfolio')->storeAs('portfolio', 'portfolio_'.$user->email);
            }
            
            $interview=Interview::create([
                'status'=>Interview::STATUS_SCHEDULED,
                'program_id'=>$request->program,
                'career_id'=>$request->career,
                'user_id'=>$user->id,
                'CV'=> $pathCV,
                'portfolio'=> $pathPortfolio,
            ]);

            $responsable->hours()->updateExistingPivot($hour_id, [
                'interview_id' => $interview->id
            ]);

            $record=new Record();
            $record->summary="Se agendó la entrevista";
            $record->model_type=Interview::class;
            $record->model_id=$interview->id;
            $record->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json([
                'msg' => 'Ocurrió un error'
            ], 409);
        }

        return Response::json([
            'msg' => 'Entrevista agendada con éxito'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        return view('interviews.edit',[
            'interview'=>$interview,
            'notes'=>Note::where('anotable_id',$interview->id)->orderBy('created_at','DESC')->get(),
            'records'=>Record::where('model_id',$interview->id)->orderBy('created_at','DESC')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interview $interview)
    {
        $record=new Record();
        DB::beginTransaction();
        try{
            $interview->setStatus($request->status);
            $interview->update();
            $record->summary="Se definió el estatus: ".$request->status;
            $record->model_type=Interview::class;
            $record->model_id=$interview->id;
            $record->save();
            DB::commit();

        } catch (\Throwable $th) {
            alert()->error('No se actualizo es estatus de la entrevista', 'Ocurrió un error');
            DB::rollback();
        }
        alert()->success('Estatus actualizado correctamente','Entrevista actualizada');
        return redirect()->route('interviews.show',[
            'interview'=>$interview
        ]);
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

    public function apiAvailableHours(Request $request){
        return $this->getAvailableHours($request->career, $request->program);
    }

    /**
     * Obtiene los horarios diponibles para un programa según el
     * encargado y sus horarios disponibles
     * 
     * @param int $career   ID de la carrera
     * @param int program   ID del programa
     * @return Collection
     */
    private function getAvailableHours(int $career, int $program){
        $career = Career::find($career);
        $program = $career->programs()->find($program);

        if(!$career || !$program){
            return Response::json([
                'msg' => 'No se encontró el programa'
            ], 409);
        }

        $responsable = User::find($program->pivot->responsable_id);

        $availableHours = $responsable->hours()->wherePivot('interview_id', null)
            ->whereDate('datetime', '>', now()->format('Y-m-d'))
            ->orderBy('datetime')
            ->select('id', 'datetime', 'end_datetime')
            ->get();

        $availableHours->map(function($hour){
            unset($hour->pivot);
            $start = Carbon::create($hour->datetime)->locale('es_MX');
            $hour->formatted = ucfirst($start->dayName).' '.$start->day.' de '.ucfirst($start->monthName).' de '.$start->format('H:i').' hrs a '.Carbon::create($hour->end_datetime)->format('H:i').' hrs';
            return $hour;
        });

        return $availableHours;
    }

    
}
