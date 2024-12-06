<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskListController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $taskLists = auth()->user()->taskLists()
            ->withCount(['tasks as completed_tasks' => function($query) {
                $query->where('completed', true);
            }])
            ->withCount('tasks')
            ->get();

        return view('dashboard', compact('taskLists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $taskList = auth()->user()->taskLists()->create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Task list created successfully.');
    }

    public function show(TaskList $taskList)
    {
        $this->authorize('view', $taskList);
        
        $tasks = $taskList->tasks()
            ->orderBy('completed')
            ->orderBy('deadline')
            ->get();
        
        return view('task-lists.show', compact('taskList', 'tasks'));
    }

    public function destroy(TaskList $taskList)
    {
        $this->authorize('delete', $taskList);
        
        $taskList->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Task list deleted successfully.');
    }

    public function dashboard()
    {
        $taskLists = auth()->user()->taskLists()
            ->withCount(['tasks as completed_tasks' => function($query) {
                $query->where('completed', true);
            }])
            ->withCount('tasks')
            ->get();

        return view('dashboard', compact('taskLists'));
    }

    public function calendar(TaskList $taskList)
    {
        $this->authorize('view', $taskList);
        
        $tasks = $taskList->tasks()
            ->whereNotNull('deadline')
            ->orderBy('deadline')
            ->get()
            ->groupBy(function($task) {
                return $task->deadline->format('Y-m-d');
            });
        
        return view('task-lists.calendar', compact('taskList', 'tasks'));
    }
} 