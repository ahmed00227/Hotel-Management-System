<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NameRule;

class SignUpRequest extends FormRequest
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
            'name' => ['required', new NameRule],
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'profile_pic' => 'nullable|mimes:png,jpg,jpeg,webp,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Username is required.',
            'name.NameRule' => 'Username cannot contain numbers or special characters',
            'email.required' => 'Email Address is required.',
            'email.email' => 'Invalid Email Address.',
            'password.required' => 'Password field cannot be empty',
            'password.min' => 'Password must contain atleast 8 characters',
            'password.confirmed' => 'Password must match confirm password.',
            'profile_pic.mimes'=>'File format not supported.',
            'email.unique'=>'Email already associated with an account.'
        ];
    }
}
