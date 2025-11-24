<?php

namespace App\Task\Factories;

use App\Task\DTO\TaskFilterDTO;
use Illuminate\Http\Request;

class TaskFilterFactory
{
    public static function fromRequest(Request $request): TaskFilterDTO
    {
        $statusId = $request->input('filter.status_id');
        $createdById = $request->input('filter.created_by_id');
        $assignedToId = $request->input('filter.assigned_to_id');

        return new TaskFilterDTO(
            statusId: ($statusId !== null && is_numeric($statusId)) ? (int) $statusId : null,
            createdById: ($createdById !== null && is_numeric($createdById)) ? (int) $createdById : null,
            assignedToId: ($assignedToId !== null && is_numeric($assignedToId)) ? (int) $assignedToId : null,
        );
    }
}
