<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserValidationRequest extends BaseRequestFormApi
{
    
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|min:5|max:50|email|unique:users,email',
            'password' => 'required|min:6|max:30',
            'national_id' => 'required',
            'mobile' => 'required',
            'age' => 'required',
            'address' => 'required',
            'type' => 'required',
        ];
    }
}