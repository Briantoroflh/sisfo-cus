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
            'id_user'           => 'required|exists:users,id_user',
            'id_details_borrow' => 'required|exists:details_borrows,id_details_borrow',
            'status'            => 'required|in:approved,not approved,pending',
            'soft_delete'       => 'nullable|in:0,1',
        ];
    }
}
