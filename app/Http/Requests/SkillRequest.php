<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
       return [
            'skill_name' => 'required|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'skill_level' => 'nullable|string|in:Beginner,Intermediate,Expert',
            'certification' => 'nullable|string|in:Yes,No',
           'sample_pictures' => 'nullable|array|max:3',
            'sample_pictures.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2048 KB = 2MB
            'sample_videos.*' => 'nullable|file|mimes:mp4,avi,mov|max:10240', // Allow multiple videos

        ];
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
