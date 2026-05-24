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
        $validated['color'] = $validated['color'] ?? '#ffffff';

        $note = Note::create($validated);

        if ($request->expectsJson()) {
            return response()->json($note);
        }

        return redirect()->route('notes.index');
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

        if ($request->expectsJson()) {
            return response()->json($note);
        }

        return redirect()->route('notes.index');
    }

    public function destroy(Note $note)
    {
        abort_if($note->user_id !== Auth::id(), 403);
        $note->delete();

        if (request()->expectsJson()) {
            return response()->json(['deleted' => true]);
        }

        return redirect()->route('notes.index');
    }
}
