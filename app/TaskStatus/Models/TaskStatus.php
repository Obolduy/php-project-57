<?php

namespace App\TaskStatus\Models;

use App\Task\Models\Task;
use Database\Factories\TaskStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @phpstan-consistent-constructor
 */
class TaskStatus extends Model
{
    /** @use HasFactory<TaskStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): TaskStatusFactory
    {
        return TaskStatusFactory::new();
    }

    /**
     * @phpstan-return HasMany<Task, $this>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
