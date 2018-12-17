<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use \Crypt;

class StoreRole extends FormRequest
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
            $id = Crypt::decrypt($request->input('id'));
        }

        return [
            'name' => [
                "required_without:id",
                Rule::unique('roles')->ignore($id)
                ->where(function ($query) {
                    return $query->where('deleted_at','=',null);
                })
            ],
            'description' => 'required',
            'permission_id' => 'required'
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
            'name.required_without' => 'role name filed is required',
            'name.unique' => 'Role Name Already Exist',
            'description.required' => 'description filed is required',
            'permission_id.required'=> 'Permission is Required',
        ];
    }
}
