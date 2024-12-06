<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'deadline',
        'completed',
        'task_list_id'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed' => 'boolean',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class);
    }
} 