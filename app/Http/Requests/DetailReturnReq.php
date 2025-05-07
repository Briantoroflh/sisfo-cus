<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailReturnReq extends FormRequest
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
            'id_borrowed' => 'required|exists:borroweds,id_borrowed',
            'status' => 'required|in:approve,not approve,pending',
            'date_return' => 'required|date',
        ];
    }
}
