<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255|unique:tasks,title,'.@$this->task->id,
            'description'   => 'nullable|string|max:255',
        ];
    }
}
