<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function index()
    {
        if (Auth::guard('clinica')->check()) {
            $consultas = Consulta::with(['pet', 'user'])
                ->where('clinica_id', Auth::guard('clinica')->id())
                ->orderBy('data')
                ->orderBy('hora')
                ->get();

            return view('consultas.index', ['consultas' => $consultas, 'modo' => 'clinica']);
        }

        if (Auth::guard('web')->check()) {
            $consultas = Consulta::with(['clinica', 'pet'])
                ->where('user_id', Auth::id())
                ->orderBy('data')
                ->orderBy('hora')
                ->get();

            return view('consultas.index', ['consultas' => $consultas, 'modo' => 'tutor']);
        }

        abort(403);
    }

    public function create()
    {
        $pets = Pet::where('user_id', Auth::id())->orderBy('nome')->get();
        $clinicas = Clinica::orderBy('nome')->get();

        return view('consultas.create', compact('pets', 'clinicas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'clinica_id' => 'required|integer|exists:clinicas,id',
            'pet_id' => 'required|integer|exists:pets,id',
            'data' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:500',
        ]);

        $pet = Pet::where('id', $data['pet_id'])->where('user_id', Auth::id())->first();
        if (!$pet) {
            return redirect()->back()->withErrors(['pet_id' => 'Você só pode agendar consulta para pets da sua conta.'])->withInput();
        }

        Consulta::create([
            'clinica_id' => $data['clinica_id'],
            'pet_id' => $data['pet_id'],
            'user_id' => Auth::id(),
            'data' => $data['data'],
            'hora' => $data['hora'],
            'motivo' => $data['motivo'],
            'status' => 'pendente',
        ]);

        return redirect()->route('dashboard')->with('status', 'Consulta agendada.');
    }

    public function aceitar($id)
    {
        if (!Auth::guard('clinica')->check()) {
            abort(403);
        }

        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', Auth::guard('clinica')->id())
            ->firstOrFail();

        $consulta->status = 'aceita';
        $consulta->save();

        return redirect()->route('consultas.index')->with('status', 'Consulta aceita com sucesso.');
    }

    public function recusar($id)
    {
        if (!Auth::guard('clinica')->check()) {
            abort(403);
        }

        $consulta = Consulta::where('id', $id)
            ->where('clinica_id', Auth::guard('clinica')->id())
            ->firstOrFail();

        $consulta->status = 'recusada';
        $consulta->save();

        return redirect()->route('consultas.index')->with('status', 'Consulta recusada com sucesso.');
    }
}
