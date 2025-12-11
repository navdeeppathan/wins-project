<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'states' => State::orderBy('name')->get()
        ], 200);
    }
}
