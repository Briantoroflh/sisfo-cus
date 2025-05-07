<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailBorrowReq extends FormRequest
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
            'id_items' => 'required|integer',
            'used_for' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'date_borrowed'     => 'required|date',
            'due_date'          => 'required|date|after_or_equal:date_borrowed',
        ];
    }
}
