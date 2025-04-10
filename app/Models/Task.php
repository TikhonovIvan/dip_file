<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    use HasFactory;

    protected $fillable = [
        'name', 'content', 'user_id', 'file','department_id', 'status'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function files()
    {
        return $this->hasMany(TaskFile::class);
    }
}
