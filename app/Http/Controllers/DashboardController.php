<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
}