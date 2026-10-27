<?php

namespace App\Http\Requests\ChatGroup;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChatGroupRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'uuid',
                'exists:chat_groups,id'
            ],
            'name' => [
                'sometimes',
                'string',
                'max:100'
            ],
            'description' => [
                'sometimes',
                'string'
            ]
        ];
    }

    public function prepareForValidation(): void 
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
