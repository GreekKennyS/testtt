<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
            'task_list_id' => 'required|exists:task_lists,id'
        ]);

        $taskList = TaskList::findOrFail($validated['task_list_id']);
        $this->authorize('view', $taskList); // Ensure user can access this task list

        $task = $taskList->tasks()->create($validated);

        return redirect()->route('task-lists.show', $taskList)
            ->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'deadline' => 'nullable|date',
            'completed' => 'sometimes|boolean',
        ]);

        $task->update($validated);

        return redirect()->back()
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $taskList = $task->taskList;
        $task->delete();

        return redirect()->route('task-lists.show', $taskList)
            ->with('success', 'Task deleted successfully.');
    }

    public function toggleComplete(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        
        return redirect()->back()
            ->with('success', 'Task status updated.');
    }
} 