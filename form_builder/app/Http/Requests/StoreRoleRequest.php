<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
        $role = $this->role;

        return [
            'name' => [
                'required', 'string', Rule::unique('roles', 'name')->when($role, function ($q) use ($role) {
                    return $q->ignore($role->id);
                })

            ]
        ];
    }

   /**
     * Display the custom validation message apply to the role request.
     *
     * @author DEVIT
     * @return Array
     */
    public function messages()
    {
        return [
            'name.required' => 'Role name is required!',
            'name.unique'   => __('Role name ":name" has been already taken !', ['name' => request()->name]),
        ];
    }
}
