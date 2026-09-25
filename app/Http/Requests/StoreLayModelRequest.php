<?php

namespace App\Http\Requests;

use App\Models\FabricGroup;
use Illuminate\Foundation\Http\FormRequest;

class StoreLayModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'lay_model_code'   => 'required|string|max:50|unique:lay_models,lay_model_code',
            'lay_model_name'   => 'required|string|max:255',
            'fabric_group_id'  => 'required|exists:fabric_groups,id',
            'fabric_id'        => 'required|exists:fabrics,id',
            'lay_length'       => 'required|numeric|min:0',
            'lay_width'        => 'required|numeric|min:0',
            'number_of_plies'  => 'required|integer|min:1',
            'garment_size'     => 'nullable|string|max:50',
            'marker_length'    => 'nullable|numeric|min:0',
            'marker_width'     => 'nullable|numeric|min:0',
            'description'      => 'nullable|string',
            'status'           => 'required|in:active,inactive',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $groupId = $this->input('fabric_group_id');
            $fabricId = $this->input('fabric_id');

            if ($groupId && $fabricId) {
                $group = FabricGroup::find($groupId);
                if ($group && !$group->fabrics()->where('fabrics.id', $fabricId)->exists()) {
                    $validator->errors()->add(
                        'fabric_id',
                        'The selected fabric does not belong to the selected fabric group.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'lay_model_code.required'  => 'Lay model code is required.',
            'lay_model_code.unique'    => 'This lay model code already exists.',
            'lay_model_name.required'  => 'Lay model name is required.',
            'fabric_group_id.required' => 'Please select a fabric group.',
            'fabric_id.required'       => 'Please select a fabric.',
            'lay_length.required'      => 'Lay length is required.',
            'lay_length.min'           => 'Lay length cannot be negative.',
            'lay_width.required'       => 'Lay width is required.',
            'lay_width.min'            => 'Lay width cannot be negative.',
            'number_of_plies.required' => 'Number of plies is required.',
            'number_of_plies.min'      => 'Number of plies must be at least 1.',
        ];
    }
}
