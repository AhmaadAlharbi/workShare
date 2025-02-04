<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNote extends Model
{
    /** @use HasFactory<\Database\Factories\TaskNoteFactory> */
    use HasFactory;
    protected $fillable = ['task_id', 'user_id', 'note'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}