<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Auth::user()->notes()
            ->orderByDesc('pinned')
            ->orderByDesc('updated_at')
            ->get();

        if (request()->expectsJson()) {
            return response()->json($notes);
        }

        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'body'  => 'nullable|string',
            'color' => 'nullable|string|max:20',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['color']   = $validated['color'] ?? '#1a1827';

        $note = Note::create($validated);

        return response()->json($note);
    }

    public function update(Request $request, Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title'  => 'nullable|string|max:255',
            'body'   => 'nullable|string',
            'color'  => 'nullable|string|max:20',
            'pinned' => 'nullable|boolean',
        ]);

        $note->update($validated);

        return response()->json($note);
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);
        $note->delete();

        return response()->json(['deleted' => true]);
    }
}