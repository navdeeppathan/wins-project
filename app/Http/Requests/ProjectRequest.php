<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all authenticated users
    }

    public function rules(): array
    {
        return [
            'nit_number' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'estimated_amount' => 'required|numeric',

            'time_allowed_number' => 'required|numeric',
            'time_allowed_type' => 'required|in:Days,Weeks,Months',

            'emd_amount' => 'nullable|numeric',
            'emd_type' => 'nullable|string',
            'emd_file' => 'nullable|mimes:pdf,jpg,png|max:2048',

            'date_of_opening' => 'nullable|date',
            'date_of_start' => 'nullable|date',
            'stipulated_completion' => 'nullable|date',
        ];
    }
}
