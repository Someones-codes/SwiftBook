<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            // No after_or_equal:today here — editing a past appointment
            // (e.g. marking it completed) must still be allowed.
            'appointment_date'  => ['required', 'date'],
            'appointment_time'  => ['required', 'date_format:H:i'],
            'status'            => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
            'notes'             => ['nullable', 'string'],
        ];
    }
}
