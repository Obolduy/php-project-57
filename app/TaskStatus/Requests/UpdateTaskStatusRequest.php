<?php

namespace App\TaskStatus\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $taskStatusId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:task_statuses,name,' . $taskStatusId],
        ];
    }
}
