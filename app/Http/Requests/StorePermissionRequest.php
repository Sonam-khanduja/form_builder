<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
            'name' => ['required','unique:permissions,name']
        ];
        
    }
    /**
     * Display the custom validation message apply to the permission request.
     *
     * @author DEVIT
     * @return Array
     */
    public function messages()
    {
       
        return [
            'name.required' => 'Permission name is required!',
            'name.unique'   => __('Permission name ":name" has been already taken!', ['name' => request()->name]),
        ];
      
    }
}
