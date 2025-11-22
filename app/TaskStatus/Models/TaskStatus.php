<?php

namespace App\TaskStatus\Models;

use App\Task\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\TaskStatusFactory::new();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
