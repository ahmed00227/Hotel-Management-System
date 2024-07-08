<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'title'=>'required|string|max:80',
            'description'=>'required|string|max:300',
            'room_pic' => 'required|mimes:png,jpg,jpeg,webp,gif',
            'address' => 'required|string|max:200',
            'daily_rent' => 'required|numeric|max_digits:5',
            'city' => 'required',
            'country'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title must be entered',
            'description.required' => 'Description must be entered',
            'room_pic.required' => 'The picture of the room must be provided',
            'room_pic.mimes' => 'The file format not  supported.',
            'address.required' => 'The address field is required.',
            'daily_rent.required' => 'Daily Rent must be provided',
            'daily_rent.numeric' => 'Enter a valid Amount.',
            'daily_rent.max_digits' => 'This exceeds the daily rent limit.',
            'city.required' => 'City must be Entered',
        ];
    }
}
