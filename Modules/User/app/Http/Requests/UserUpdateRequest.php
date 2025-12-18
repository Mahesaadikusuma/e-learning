<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('users', 'name')->ignore($this->user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'role' => 'required|exists:roles,uuid',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,uuid',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
