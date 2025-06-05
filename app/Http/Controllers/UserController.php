<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    private function validator(array $data){
        return Validator::make($data,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required','string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'pin' => ['nullable', 'unique:users,pin','string', 'min:4', 'max:4'],
            'rol' => ['required'],
            'area' => ['required'],
        ],[
            'first_name.required' => 'El campo nombre es requerido',
            'last_name.required' => 'El campo apellido es requerido',
            'email.required' => 'El campo email es requerido',
            'email.unique' => 'El email ya se registró',
            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'La contraseña tener mínimo 8 caracteres',
            'pin.required' => 'El campo PIN es requerido',
            'pin.unique' => 'El pin ya se registró',
            'rol.required' => 'El campo rol es requerido',
            'area.required' => 'El campo área es requerido',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    // Comenzar sin filtro de estado (solo excluyendo candidatos)
    $usersToShowQuery = User::noCandidates();

    // Si se aplica algún filtro, construir las condiciones
    if ($request->bloqueados || $request->desabilitados || $request->activos) {
        $usersToShowQuery = $usersToShowQuery->where(function ($query) use ($request) {
            if ($request->bloqueados) {
                $query->orWhere('status', User::STATUS_LOCKED);
            }
            if ($request->desabilitados) {
                $query->orWhere('status', User::STATUS_DISABLED);
            }
            if ($request->activos) {
                $query->orWhere('status', User::STATUS_ACTIVE);
            }
        });
    }

        return view('users.index', [
            'authenticatedUser' => Auth::user(),
            'users'=>$usersToShowQuery->get()
        ]);
    }

    public function candidates(Request $request)
    {
        $canditateStatusInterview = User::whereRoleIs(Role::ROLE_CANDIDATE)->whereHas('interview', function ($query) {
            $query->where('status', '=', 'scheduled');
        
        });

        $canditateStatusInterview = $canditateStatusInterview->orWhere(function($query){
            return $query->whereHas('interview', function ($query){
                $query->where('status', '=', 'done-checking');
            });
        });

        $canditateStatusInterview = $canditateStatusInterview->orWhere(function($query){
            return $query->whereHas('interview', function ($query){
                $query->where('status', '=', 'done-accepted');
            });
        });

        $canditateStatusInterview = $canditateStatusInterview->orWhere(function($query){
            return $query->whereHas('interview', function ($query){
                $query->where('status', '=', 'done-enrolled');
            });
        });

            $marcado = '0';

        if($request->noRealizada){
            $canditateStatusInterview = $canditateStatusInterview->orWhere(function($query){
                return $query->whereHas('interview', function ($query){
                    $query->where('status', '=', 'unrealized');
                });
            });
            $marcado = '1';
        }

        if($request->rechazados){
            $canditateStatusInterview = $canditateStatusInterview->orWhere(function($query){
                return $query->whereHas('interview', function ($query){
                    $query->where('status', '=', 'done-rejected');
                });
            });
            if($marcado == '1'){
                $marcado = '3';
            }else{
                $marcado = '2';
            }
            
        }

        return view('users.candidates', [
            'user' => Auth::user(),
            'candidates'=>$canditateStatusInterview->get(),
            'marcado' => $marcado
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register',[
            'authenticatedUser' => Auth::user(),
            'roles'=>Role::all()
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
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'area' => 'required|max:255',
            'password' => 'required|min:8|max:255|confirmed',
            'password_confirmation' => 'required',
            'pin' => 'nullable|unique:users,pin|min:4|max:4',
            'rol' => 'required',
            'phone'=> 'nullable|min:10|max:10',
            'contact_phone'=> 'nullable',
            'contact_name'=> 'nullable',
            'address'=> 'nullable',
        ],[
            'first_name.required' => 'El campo nombre es requerido',
            'last_name.required' => 'El campo apellido es requerido',
            'email.required' => 'El campo email es requerido',
            'email.unique' => 'El email ya se registró',
            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'La contraseña tener mínimo 8 caracteres',
            'pin.required' => 'El campo PIN es requerido',
            'pin.unique' => 'El pin ya se registró',
            'rol.required' => 'El campo rol es requerido',
            'area.required' => 'El campo área es requerido',
        ]);
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'pin' => $request->pin ? : null,
                'area' => $request->area,
                'phone' => $request->phone ? : null,
                'contact_name' => $request->contact_name ? : null,
                'contact_phone' => $request->contact_phone ? : null,
                'address' => $request->address ? : null,
            ]);
            $user->attachRoles(explode(',', $request->rol));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json([
                'msg' => 'ocurrio un problemas al intentar registrar al usuario'
            ], 409);
        }
        
        return redirect()->route('users.index');
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
    public function edit(User $user)
    {
        return view('users.edit',[
            'authenticatedUser' => Auth::user(),
            'userToEdit'=>$user,
            'roles'=>Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $this->validator($request->only(['first_name','last_name','password','email','pin','area']));

        DB::beginTransaction();
        try {
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            $user->pin=$request->pin;
            $user->area=$request->area;
            $user->phone=$request->has('phone') ? $request->phone : null;
            $user->contact_name=$request->has('contact_name') ? $request->contact_name : null;
            $user->contact_phone=$request->has('contact_phone') ? $request->contact_phone : null;
            $user->address=$request->has('address') ? $request->address : null;
            $user->update();

            $user->syncRoles($request->rol);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('alert','Se elimino el usuario');
    }

    public function activate(User $user){
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        alert()->success('estado del Usuario ' . $user->first_name . ': Activo', 'Completado el cambio de estado');

        return redirect()->route('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
    public function lock(User $user){
        $user->status = User::STATUS_LOCKED;
        $user->save();
        alert()->success('estado del Usuario ' . $user->first_name . ': Bloqueado', 'Completado el cambio de estado');

        return redirect()->route('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
    public function disable(User $user){
        $user->status = User::STATUS_DISABLED;
        $user->save();
        alert()->success('estado del Usuario ' . $user->first_name . ': Desabilitado', 'Completado el cambio de estado');
        
        return redirect()->route('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
}

