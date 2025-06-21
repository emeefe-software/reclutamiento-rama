<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interview;
use App\Role;
use Auth;

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

        if($authenticatedUser->hasRole(Role::ROLE_PRACTICING)) {
            $rol = 'Practicing';
            return view('dashboard.welcome', [
                'authenticatedUser' => $authenticatedUser,
                'rol' => $rol,
            ]);
        }   

        if($authenticatedUser->hasRole(Role::ROLE_CANDIDATE)) {
            $rol = 'Candidate';
            return view('dashboard.welcome', [
                'authenticatedUser' => $authenticatedUser,
                'rol' => $rol,
            ]);
        }   
    }
}
