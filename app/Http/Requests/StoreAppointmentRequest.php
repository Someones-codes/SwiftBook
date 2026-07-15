<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'       => ['required', 'exists:customers,id'],
            'service_id'        => ['required', 'exists:services,id'],
            'appointment_date'  => ['required', 'date', 'after_or_equal:today'],
            'appointment_time'  => ['required', 'date_format:H:i'],
            'status'            => ['sometimes', 'in:pending,confirmed,completed,cancelled,no_show'],
            'notes'             => ['nullable', 'string'],
        ];
    }
}
