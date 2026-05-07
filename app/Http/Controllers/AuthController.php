<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:usuario,clinica',
            'documento' => 'required|string',
            'password' => 'required|string',
        ]);

        $doc = preg_replace('/\D/', '', $request->documento);

        if ($request->tipo === 'usuario') {
            if (strlen($doc) !== 11) {
                return back()->withErrors(['documento' => 'Informe um CPF válido (11 dígitos).'])->withInput();
            }

            if (Auth::guard('web')->attempt(['cpf' => $doc, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();

                return redirect()->intended('/dashboard');
            }
        } else {
            if (strlen($doc) !== 14) {
                return back()->withErrors(['documento' => 'Informe um CNPJ válido.'])->withInput();
            }

            if (Auth::guard('clinica')->attempt(['cnpj' => $doc, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();

                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors(['documento' => 'Login inválido.'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:usuario,clinica',
        ]);

        if ($request->input('tipo') === 'clinica') {
            $request->merge(['cnpj' => preg_replace('/\D/', '', (string) $request->cnpj)]);

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'cnpj' => 'required|digits:14|unique:clinicas,cnpj',
                'cidade' => 'required|string|max:255',
                'uf' => 'required|string|size:2',
                'password' => 'required|string|min:6',
            ]);

            Clinica::create([
                'nome' => $validated['nome'],
                'cnpj' => $validated['cnpj'],
                'cidade' => strtoupper($validated['cidade']),
                'uf' => strtoupper($validated['uf']),
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('login')->with('status', 'Clínica cadastrada. Faça login com o CNPJ e a senha.');
        }

        $request->merge(['cpf' => preg_replace('/\D/', '', (string) $request->cpf)]);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'email' => 'required|email|max:255|unique:users,email',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'nome' => $validated['nome'],
            'cpf' => $validated['cpf'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('pets.create');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('clinica')->check()) {
            Auth::guard('clinica')->logout();
            $request->session()->forget('unlocked_pet_ids');
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
