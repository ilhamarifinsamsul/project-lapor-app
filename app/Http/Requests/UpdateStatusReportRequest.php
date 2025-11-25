<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusReportRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'report_id' => 'required|exists:reports,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ];
    }
}
