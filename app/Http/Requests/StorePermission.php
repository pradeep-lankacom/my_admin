<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            //'slug' => 'required|max:255',
            //'breadcrumb' => 'required|max:255',
            //'title' => 'required|max:255'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'Description is required',
            'description.max' => 'Maximum size is 255 characters',

            'name.required' => 'Name is required',
            'name.max' => 'Maximum size is 255 characters',

            // 'slug.required' => 'Slug is required',
            // 'slug.max' => 'Maximum size is 255 characters',

            // 'breadcrumb.required' => 'Breadcrumb is required',
            // 'breadcrumb.max' => 'Maximum size is 255 characters',

            // 'title.required' => 'Title is required',
            // 'title.max' => 'Maximum size is 255 characters',
        ];
    }
}
