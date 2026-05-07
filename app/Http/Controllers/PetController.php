<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pet;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetController extends Controller
{
    protected function tutorDono(Pet $pet): bool
    {
        return Auth::guard('web')->check() && (int) $pet->user_id === (int) Auth::id();
    }

    protected function clinicaComFicha(Pet $pet): bool
    {
        $liberados = session('unlocked_pet_ids', []);

        return Auth::guard('clinica')->check()
            && in_array((int) $pet->id, array_map('intval', $liberados), true);
    }

    protected function authorizeFicha(Pet $pet): void
    {
        if ($this->tutorDono($pet) || $this->clinicaComFicha($pet)) {
            return;
        }

        abort(403);
    }

    public function index()
    {
        $pets = Pet::where('user_id', Auth::id())->orderBy('nome')->get();

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'raca' => 'nullable|string|max:255',
            'cor' => 'nullable|string|max:255',
            'nascimento' => 'nullable|date',
            'vacina' => 'nullable|string|max:255',
            'data_vacina' => 'nullable|date',
            'doenca' => 'nullable|string|max:255',
            'observacao' => 'nullable|string|max:2000',
            'senha_ficha' => 'required|string|min:4',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pets', 'public');
        }

        Pet::create([
            'user_id' => Auth::id(),
            'nome' => $data['nome'],
            'raca' => $data['raca'] ?? null,
            'cor' => $data['cor'] ?? null,
            'nascimento' => $data['nascimento'] ?? null,
            'vacina' => $data['vacina'] ?? null,
            'data_vacina' => $data['data_vacina'] ?? null,
            'doenca' => $data['doenca'] ?? null,
            'observacao' => $data['observacao'] ?? null,
            'senha' => Hash::make($data['senha_ficha']),
            'foto' => $fotoPath,
        ]);

        return redirect()->route('pets.index')->with('status', 'Pet cadastrado. Anote o ID da ficha e a senha para liberar o acesso na clínica.');
    }

    public function show(Pet $pet)
    {
        $this->authorizeFicha($pet);
        $pet->load('user');

        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        $this->authorizeFicha($pet);

        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $this->authorizeFicha($pet);

        $rules = [
            'nome' => 'required|string|max:255',
            'raca' => 'nullable|string|max:255',
            'cor' => 'nullable|string|max:255',
            'nascimento' => 'nullable|date',
            'vacina' => 'nullable|string|max:255',
            'data_vacina' => 'nullable|date',
            'doenca' => 'nullable|string|max:255',
            'observacao' => 'nullable|string|max:2000',
            'foto' => 'nullable|image|max:2048',
        ];

        if ($this->tutorDono($pet)) {
            $rules['senha_ficha'] = 'nullable|string|min:4';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pets', 'public');
        }

        if ($this->tutorDono($pet) && $request->filled('senha_ficha')) {
            $data['senha'] = Hash::make($request->senha_ficha);
        }

        unset($data['senha_ficha']);

        $pet->update($data);

        return redirect()->route('pets.show', $pet)->with('status', 'Ficha atualizada.');
    }

    public function destroy(Pet $pet)
    {
        if (! $this->tutorDono($pet)) {
            abort(403);
        }

        $pet->delete();

        return redirect()->route('pets.index')->with('status', 'Pet removido.');
    }

    public function pdf(Pet $pet)
    {
        $this->authorizeFicha($pet);

        $consulta = null;

        if (Auth::guard('clinica')->check()) {
            $consulta = Consulta::where('pet_id', $pet->id)
                ->where('clinica_id', Auth::guard('clinica')->id())
                ->orderBy('data')
                ->orderBy('hora')
                ->first();
        } else {
            $consulta = Consulta::where('pet_id', $pet->id)
                ->where('user_id', Auth::id())
                ->orderBy('data')
                ->orderBy('hora')
                ->first();
        }

        $nomeArquivo = 'ficha-medica-pet-' . $pet->id . '.pdf';
        $agora = Carbon::now();

        $pdf = Pdf::loadView('pets.pdf', [
            'pet' => $pet->load('user'),
            'consulta' => $consulta ? $consulta->load('clinica') : null,
            'dataGeracao' => $agora->format('d/m/Y'),
            'horaGeracao' => $agora->format('H:i'),
        ]);

        return $pdf->download($nomeArquivo);
    }
}
