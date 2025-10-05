<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
           'person.first_name' => 'required|string|max:255',
        'person.last_name'  => 'required|string|max:255',
        'person.gender'     => 'required|string|in:Male,Female,Other',
        'person.phone'      => 'required|string|max:20',
        'person.street'     => 'required|string|max:255',
        'person.number'     => 'required|string|max:50',
        'person.city'       => 'required|string|max:255',
        'person.zip'        => 'required|string|max:20',
        'person.country'    => 'required|string',
        'person.region'     => 'nullable|integer|exists:regions,id',
        // Optional fields
        'person.university_name'     => 'nullable|string|max:255',
        'person.university_address'  => 'nullable|string|max:255',
        'person.start_year'          => 'nullable|integer',
        'person.finish_year'         => 'nullable|integer',
        'person.student_id_picture_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'person.student_id_picture_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ];

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
