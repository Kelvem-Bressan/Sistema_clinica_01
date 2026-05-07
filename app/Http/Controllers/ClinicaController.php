<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Http\Requests\StoreClinicaRequest;
use App\Http\Requests\UpdateClinicaRequest;

class ClinicaController extends Controller
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
     * @param  \App\Http\Requests\StoreClinicaRequest  $request
     * @return \Illuminate\Http\Response
     */
    use App\Models\Clinica;

    public function store(Request $request)
{
    Clinica::create([
        'cnpj' => $request->cnpj,
        'nome' => $request->nome,
        'cidade' => $request->cidade,
        'uf' => $request->uf,
        'password' => bcrypt($request->password)
    ]);

    return back();
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function show(Clinica $clinica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function edit(Clinica $clinica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClinicaRequest  $request
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClinicaRequest $request, Clinica $clinica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinica $clinica)
    {
        //
    }
    
}
