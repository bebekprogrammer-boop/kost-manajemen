<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|regex:/^[0-9]+$/|max:20',
            'email' => 'nullable|email|max:150',
            'id_card_number' => 'nullable|string|max:50',
            'id_card_photo' => 'nullable|image|max:5120',
            'check_in_date' => 'required|date',
            'rent_duration' => 'required|integer|in:1,3,6,12',
            'notes' => 'nullable|string'
        ];

        // Validasi room_id hanya saat create (karena pindah kamar tidak bisa lewat edit)
        if ($this->isMethod('post')) {
            $rules['room_id'] = 'required|exists:rooms,id';
        }

        return $rules;
    }
}
