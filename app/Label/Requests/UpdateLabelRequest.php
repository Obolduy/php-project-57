<?php

namespace App\Label\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabelRequest extends FormRequest
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
        $label = $this->route('label');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:labels,name,' . $label->id],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.unique' => __('labels.already_exists'),
        ];
    }
}
