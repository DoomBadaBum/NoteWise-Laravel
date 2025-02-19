<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class NoteController extends Controller
{
    public function myNotes(Request $request)
    {
        // Start by selecting notes that belong to the logged-in user
        $notes = Note::where('user_id', Auth::id());
    
        // 1. Text Search (name or description)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $notes->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // 2. Filter by Start Date (created_at >= startDate)
        if ($request->filled('startDate')) {
            $notes->whereDate('created_at', '>=', $request->input('startDate'));
        }
    
        // 3. Filter by End Date (created_at <= endDate)
        if ($request->filled('endDate')) {
            $notes->whereDate('created_at', '<=', $request->input('endDate'));
        }
    
        // 4. Has Remarks?
        if ($request->filled('hasRemarks')) {
            if ($request->input('hasRemarks') === '1') {
                // Only notes that have remarks
                $notes->has('remarks');
            } else {
                // Only notes without remarks
                $notes->doesntHave('remarks');
            }
        }
    
        // Finally, fetch with remarks (and user if needed)
        $notes = $notes->with('remarks.user')->get();
    
        return view('notes.myNotes', compact('notes'));
    }
    

    public function index(Request $request)
    {
        // Start with a base query for notes.
        // If you only want the logged-in user's notes:
        // $notes = Note::where('user_id', auth()->id());
        // else:
        $notes = Note::query();

        // 1. Text Search (name or description)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $notes->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 2. Filter by Start Date (created_at >= startDate)
        if ($request->filled('startDate')) {
            $notes->whereDate('created_at', '>=', $request->input('startDate'));
        }

        // 3. Filter by End Date (created_at <= endDate)
        if ($request->filled('endDate')) {
            $notes->whereDate('created_at', '<=', $request->input('endDate'));
        }

        // 4. Has Remarks?
        // - If '1', return notes that have at least one remark
        // - If '0', return notes that have no remarks
        if ($request->filled('hasRemarks')) {
            if ($request->input('hasRemarks') === '1') {
                // Only notes that have remarks
                $notes->has('remarks');
            } else {
                // Only notes without remarks
                $notes->doesntHave('remarks');
            }
        }

        // Finally, get or paginate the results:
        $notes = $notes->with('remarks.user')->get(); 
        // or ->paginate(10);

        return view('notes.index', compact('notes'));
    }

    public function show(Note $note)
    {
        // Eager load remarks and their user
        $note->load('remarks.user');
        return view('notes.show', compact('note'));
    }
    
    /**
     * Show the form for creating a new note.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created note in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        Note::create([
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => Auth::id(),
        ]);
    
        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified note in the database.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified note from the database.
     */
    public function destroy(Note $note)
    {
        // Quick fix: only allow the owner to delete
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}
