<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskNote;
use App\Models\Department;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index()
    {
        $department_id = Auth::user()->department_id;
        // $tasks = Department::find($department_id)->tasks;
        $tasks = Task::where('department_id', $department_id)->get();
        return view('index', compact('tasks'));
    }
    public function sharedTasks()
    {
        $department_id = Auth::user()->department_id;
        $tasks = Department::find($department_id)
            ->tasks()
            ->whereHas('departments', function ($query) use ($department_id) {
                $query->where('departments.id', $department_id);
            })
            ->get();

        return view('index', compact('tasks'));
    }
    public function allTasks()
    {
        $department_id = Auth::user()->department_id;

        // Get tasks created by the department
        $createdTasks = Task::where('department_id', $department_id);

        // Get shared tasks through the pivot table
        $sharedTasks = Task::whereHas('departments', function ($query) use ($department_id) {
            $query->where('departments.id', $department_id);
        });

        // Combine both queries
        $tasks = $createdTasks->union($sharedTasks)
            ->with('departments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('index', compact('tasks'));
    }
    public function create()
    {
        $department_id = Auth::user()->department_id;
        $departments = Department::all();
        $users = User::where('department_id', $department_id)->get();
        return view('tasks.create', compact('departments', 'users'));
    }
    public function sendTestEmail()
    {
        // Simple email to yourself
        $toEmail = 'ahmaadzaid7@gmail.com'; // Replace with your email address

        // Send the email
        Mail::raw('This is a test email from Laravel.', function ($message) use ($toEmail) {
            $message->to($toEmail)
                ->subject('Test Email');
        });

        // Return a response indicating the email was sent
        return response()->json(['message' => 'Test email sent successfully']);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,in-progress,completed',
            'assigned_user_id' => 'required|exists:users,id',
            'departments' => 'required|array|exists:departments,id'
        ]);

        $task = DB::transaction(function () use ($validated) {
            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'assigned_user_id' => $validated['assigned_user_id'],
                'user_id' => Auth::id(),
                'department_id' => Auth::user()->department_id
            ]);

            $task->departments()->attach($validated['departments']);

            // Send notification to assigned user
            $assignedUser = User::find($validated['assigned_user_id']);
            $assignedUser->notify(new TaskAssigned($task));

            return $task;
        });

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
    public function show(Task $task)
    {
        $taskNotes = TaskNote::where('task_id', $task->id)->latest()->paginate(5);
        $taskComments = TaskComment::where('task_id', $task->id)->latest()->get();
        $departments = Department::all();
        return view('tasks.show', compact('task', 'departments', 'taskNotes', 'taskComments'));
    }

    public function edit(Task $task)
    {
        $departments = Department::all();
        return view('tasks.edit', compact('task', 'departments'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,in-progress,completed',
            'departments' => 'required|array'
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status']
        ]);

        $task->departments()->sync($validated['departments']);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        if ($task->department_id !== Auth::user()->department_id) {
            return back()->with('error', 'Unauthorized action');
        }

        $task->departments()->detach();
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
