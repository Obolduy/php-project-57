<?php

namespace App\Label\Models;

use App\Task\Models\Task;
use Database\Factories\LabelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @phpstan-consistent-constructor
 */
class Label extends Model
{
    /** @use HasFactory<LabelFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function newFactory(): LabelFactory
    {
        return LabelFactory::new();
    }

    /**
     * @phpstan-return BelongsToMany<Task, $this>
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
