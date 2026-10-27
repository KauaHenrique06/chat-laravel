<?php

namespace App\Http\Requests\ChatGroup;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChatGroupIntegrantRequest extends FormRequest
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
            'user_id' => [
                'required',
                'uuid',
                // Must be an integrant of this group
                Rule::exists('chat_group_integrant', 'user_id')->where('chat_group_id', $this->route('id'))
            ],
            'is_admin' => [
                'required',
                'boolean'
            ]
        ];
    }

    public function prepareForValidation(): void 
    {
        $this->merge([
            'id' => $this->route('id'),
            'user_id' => $this->route('userId'),
        ]);
    }
}
