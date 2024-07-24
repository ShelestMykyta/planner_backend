<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\CustomRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateTaskRequest extends CustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s|before:end_time',
            'end_time' => 'required|date_format:H:i:s',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not be more than 255 characters long.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
            'start_time.required' => 'The start time field is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM:SS.',
            'start_time.before' => 'The start time must be earlier than the end time.',
            'end_time.required' => 'The end time field is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM:SS.',
        ];
    }
}
