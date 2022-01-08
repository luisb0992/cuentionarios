<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    /**
     * Devuelve la vista con el listado de fases.
     *
     * @return View
     */
    public function index(): View
    {
        $phases = Phase::all();

        return view('phases.index', compact('phases'));
    }

    /**
     * Devuelve la vista de creación de fases.
     *
     * @return View
     */
    public function create(): View
    {
        return view('phases.create', [
            'lastPhaseNumber' => Phase::lastPhaseNumber(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phase $phase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phase $phase)
    {
        //
    }
}
