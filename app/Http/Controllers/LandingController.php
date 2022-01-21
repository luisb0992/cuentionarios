<?php

/**
 * Gestion del controlador de landing
 *
 * @author luisbardev <luisbardegmail.com> <luisbardev.com>
 * @copyright 2020 P4D https://project4design.com/
 */

namespace App\Http\Controllers;

use App\Models\Phase;

class LandingController extends Controller
{
    public function index()
    {
        $phases = Phase::with('videos')->get();
        return view('landing.index', compact('phases'));
    }
}
