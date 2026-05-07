<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('clinica')->check()) {
            $clinica = Auth::guard('clinica')->user();
            $consultas = Consulta::with(['pet', 'user'])
                ->where('clinica_id', $clinica->id)
                ->orderBy('data')
                ->orderBy('hora')
                ->get();

            return view('dashboard-clinica', compact('consultas', 'clinica'));
        }

        if (Auth::guard('web')->check()) {
            $pets = Pet::where('user_id', Auth::id())->orderBy('nome')->get();
            $consultas = Consulta::with(['clinica', 'pet'])
                ->where('user_id', Auth::id())
                ->orderBy('data')
                ->orderBy('hora')
                ->get();

            return view('dashboard-tutor', compact('pets', 'consultas'));
        }

        abort(403);
    }
}
