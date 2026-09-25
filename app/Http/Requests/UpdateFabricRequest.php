<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFabricRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $fabricId = is_object($this->route('fabric')) ? $this->route('fabric')->id : $this->route('fabric');
        return [
            'fabric_code'  => 'required|string|max:50|unique:fabrics,fabric_code,' . $fabricId,
            'fabric_name'  => 'required|string|max:255',
            'fabric_type'  => 'required|string|max:100',
            'composition'  => 'nullable|string|max:255',
            'color'        => 'nullable|string|max:100',
            'gsm'          => 'nullable|numeric|min:0',
            'width'        => 'nullable|numeric|min:0',
            'unit'         => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'status'       => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'fabric_code.required' => 'Fabric code is required.',
            'fabric_code.unique'   => 'This fabric code already exists.',
            'fabric_name.required' => 'Fabric name is required.',
            'fabric_type.required' => 'Fabric type is required.',
            'gsm.numeric'          => 'GSM must be a valid number.',
            'gsm.min'              => 'GSM cannot be negative.',
            'width.numeric'        => 'Width must be a valid number.',
            'width.min'            => 'Width cannot be negative.',
        ];
    }
}
