<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskNoteController extends Controller
{
    public function index()
    {
        $taskNotes = TaskNote::with(['task', 'user'])->latest()->paginate(10);
        return view('task-notes.index', compact('taskNotes'));
    }

    public function create()
    {
        $tasks = Task::all();
        return view('task-notes.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'note' => 'required|string|max:1000',
        ]);

        $taskNote = new TaskNote();
        $taskNote->task_id = $validated['task_id'];
        $taskNote->user_id = Auth::id();
        $taskNote->note = $validated['note'];
        $taskNote->save();

        return back()->with('success', 'Note added successfully.');
    }

    public function edit(TaskNote $taskNote)
    {
        $tasks = Task::all();
        return view('task-notes.edit', compact('taskNote', 'tasks'));
    }

    public function update(Request $request, TaskNote $taskNote)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'note' => 'required|string|max:1000',
        ]);

        $taskNote->update($validated);

        return redirect()->route('task-notes.index')
            ->with('success', 'Note updated successfully.');
    }

    public function destroy(TaskNote $taskNote)
    {
        $taskNote->delete();

        return redirect()->route('task-notes.index')
            ->with('success', 'Note deleted successfully.');
    }
}