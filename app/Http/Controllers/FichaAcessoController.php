<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FichaAcessoController extends Controller
{
    public function create()
    {
        return view('ficha.desbloquear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|integer|exists:pets,id',
            'senha_ficha' => 'required|string',
        ]);

        $pet = Pet::findOrFail($request->pet_id);

        if (! Hash::check($request->senha_ficha, $pet->senha)) {
            return back()->withErrors(['senha_ficha' => 'ID ou senha da ficha incorretos.'])->withInput();
        }

        $ids = session('unlocked_pet_ids', []);
        $pid = (int) $pet->id;
        if (! in_array($pid, array_map('intval', $ids), true)) {
            $ids[] = $pid;
        }
        session(['unlocked_pet_ids' => $ids]);

        return redirect()->route('pets.show', $pet)->with('status', 'Ficha desbloqueada para esta sessão.');
    }
}
