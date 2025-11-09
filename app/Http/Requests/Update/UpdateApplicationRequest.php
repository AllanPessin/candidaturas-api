<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'position' => 'sometimes|string',
            'link' => 'sometimes|string|',
            'contact' => 'nullable|string|',
            'applied_date' => 'sometimes|date',
            'interview_date' => 'nullable|date|',
            'salary' => 'nullable|decimal:2',
            'feedback' => 'nullable|string|',
            'status_id' => 'sometimes|numeric|exists:statuses,id',
            'company_id' => 'sometimes|string|exists:company,id',
            'city_id' => 'nullable|string|exists:city,id',
            'modality_id' => 'sometimes|string|exists:modalities,id',
            'contract_id' => 'sometimes|string|exists:contract,id',
            'category_id' => 'sometimes|string|exists:category,id',
        ];
    }
}
