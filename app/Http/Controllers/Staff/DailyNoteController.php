<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DailyNote;
use Illuminate\Http\Request;

class DailyNoteController extends Controller
{
    public function index() {
        $notes = DailyNote::orderBy('note_date', 'desc')->get();
        return view('staff.daily_notes.index', compact('notes'));
    }

    public function store(Request $request) {
        $note = DailyNote::create($request->all());
        return response()->json($note);
    }

    public function update(Request $request, $id) {
        $note = DailyNote::findOrFail($id);
        $note->update($request->all());
        return response()->json($note);
    }

    public function destroy($id) {
        DailyNote::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
