<?php

namespace App\Task\Factories;

use App\Task\DTO\TaskFilterDTO;
use Illuminate\Http\Request;

class TaskFilterFactory
{
    public static function fromRequest(Request $request): TaskFilterDTO
    {
        return new TaskFilterDTO(
            statusId: $request->input('filter.status_id') ? (int) $request->input('filter.status_id') : null,
            createdById: $request->input('filter.created_by_id') ? (int) $request->input('filter.created_by_id') : null,
            assignedToId: $request->input('filter.assigned_to_id') ? (int) $request->input('filter.assigned_to_id') : null,
        );
    }
}

