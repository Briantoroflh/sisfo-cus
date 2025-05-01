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
            'id_borrowed' => 'required|integer',
            'status_borrow' => 'required|string',
            'used_for' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
        ];
    }
}
