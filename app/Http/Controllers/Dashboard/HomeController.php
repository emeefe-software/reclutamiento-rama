<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interview;
use App\Role;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pendingInterviews = null;
        $authenticatedUser = Auth::user();
        $rol = '';
        $pendingInterviews = Interview::pendingInterviews()->get()->sort(function ($prevInterview, $nextInterview) {
            return $prevInterview->hour()->first()->datetime < $nextInterview->hour()->first()->datetime ? -1 : 1;
        });
        if ($authenticatedUser->hasRole(Role::ROLE_ADMIN)) {
            $rol = 'Admin';
            return view('dashboard.home', [
                'authenticatedUser' => $authenticatedUser,
                'pendingInterviews' => $pendingInterviews,
                'rol' => $rol,
            ]);
        }
        if ($authenticatedUser->hasRole(ROLE::ROLE_RESPONSABLE)) {
            $rol = 'Responsable';
            return view('dashboard.home', [
                'authenticatedUser' => $authenticatedUser,
                'pendingInterviews' => $pendingInterviews,
                'rol' => $rol,
            ]);
        }

        if ($authenticatedUser->hasRole(Role::ROLE_PRACTICING)) {
            $user = auth()->user();
            $registers = $user->registers()->whereNotNull('start_at')->orderBy('start_at')->get(['start_at', 'end_at']);
            $events = [];

            foreach ($registers as $reg) {
                // Evento de entrada
                $events[] = [
                    'title' => 'Entrada',
                    'start' => $reg->start_at->toIso8601String(),
                ];

                // Evento de salida (solo si existe)
                if ($reg->end_at) {
                    $events[] = [
                        'title' => 'Salida',
                        'start' => $reg->end_at->toIso8601String(),
                    ];
                }
            }
            
            $rol = 'Practicing';
            return view('dashboard.welcome', [
                'authenticatedUser' => $authenticatedUser,
                'rol' => $rol,
                'registers' => $events,
            ]);
        }

        if ($authenticatedUser->hasRole(Role::ROLE_CANDIDATE)) {
            $rol = 'Candidate';
            return view('dashboard.welcome', [
                'authenticatedUser' => $authenticatedUser,
                'rol' => $rol,
            ]);
        }
    }
}
