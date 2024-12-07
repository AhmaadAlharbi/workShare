<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string'
        ]);

        $comment = new TaskComment();
        $comment->task_id = $validated['task_id'];
        $comment->user_id = Auth::id();
        $comment->comment = $validated['comment'];
        $comment->save();

        return back()->with('comment_success', 'Comment added successfully.');
    }

    public function update(Request $request, TaskComment $taskComment)
    {
        $validated = $request->validate([
            'comment' => 'required|string'
        ]);

        $taskComment->update($validated);

        return back()->with('comment_success', 'Comment updated successfully.');
    }

    public function destroy(TaskComment $taskComment)
    {
        $taskComment->delete();
        return back()->with('comment_success', 'Comment deleted successfully.');
    }
}