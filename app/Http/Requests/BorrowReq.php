<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowReq extends FormRequest
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
            'id_user' => 'required|exists:users,id_user',
            'date_borrowed' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date_borrowed',
            'details' => 'required|array|min:1',
            'details.*.id_items' => 'required|exists:items,id_items',
            'details.*.amount' => 'required|integer|min:1',
            'details.*.used_for' => 'required|string'
        ];
    }
}
