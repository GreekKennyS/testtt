<?php

namespace App\Policies;

use App\Models\TaskList;
use App\Models\User;

class TaskListPolicy
{
    public function view(User $user, TaskList $taskList): bool
    {
        return $user->id === $taskList->user_id;
    }

    public function delete(User $user, TaskList $taskList): bool
    {
        return $user->id === $taskList->user_id;
    }
} 