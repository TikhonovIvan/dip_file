<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file', 'original_name']; // Добавляем original_name

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
