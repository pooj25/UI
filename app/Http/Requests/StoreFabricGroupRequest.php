<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFabricGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'group_code'  => 'required|string|max:50|unique:fabric_groups,group_code',
            'group_name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
            'fabrics'     => 'required|array|min:1',
            'fabrics.*'   => 'exists:fabrics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'group_code.required' => 'Group code is required.',
            'group_code.unique'   => 'This group code already exists.',
            'group_name.required' => 'Group name is required.',
            'fabrics.required'    => 'At least one fabric must be selected.',
            'fabrics.min'         => 'At least one fabric must be selected.',
            'fabrics.*.exists'    => 'One or more selected fabrics are invalid.',
        ];
    }
}
