<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'room_id' => 'required',
            'start_date' => 'required|date',
            'no_of_days' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'Room id is required.',
            'start_date.required' => 'Start date of the booking is required',
            'start_date.date' => 'Invalid Date Format',
            'no_of_days.required' => 'Number of days must be entered.',
            'no_of_days.numeric' => 'It should be a numeric value',
        ];
    }
}
