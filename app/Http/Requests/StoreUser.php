<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
    public function rules(Request $request)
    {
        $id = null;

        if (!empty($request->id)) {
            $id = $request->id;
        }

        return [
          'name' => 'required|string|max:255',
          'email' => [
            'required',
            'email',
            'string',
            Rule::unique('users')->ignore($id)
            ->where(function ($query) {
                return $query->where('deleted_at', '=', null);
            })
          ],
          'role_id' => 'sometimes',
          'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Please enter an email address!',
            'role_id.required' => 'Role is required!'
        ];
    }
}
