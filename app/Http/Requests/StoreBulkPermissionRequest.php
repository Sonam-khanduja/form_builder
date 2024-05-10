<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Permission;

class StoreBulkPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // change to your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bulk_name' => 'required|string',
        ];
    }

    /**
     * Handle the request after validation.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $ifExist = Permission::where('name', 'LIKE', "{$this->bulk_name}.%")->pluck('name');
            $permissions = collect([
                ['name' => "{$this->bulk_name}.list"],
                ['name' => "{$this->bulk_name}.view"],
                ['name' => "{$this->bulk_name}.create"],
                ['name' => "{$this->bulk_name}.edit"],
                ['name' => "{$this->bulk_name}.delete"],
            ]);
            $diff = $permissions->pluck('name')->diff($ifExist);
            if ($diff->isEmpty()) {
                return back()->withErrors(['bulk_name' => __('":module" module permissions already exists!', ['module' => $this->bulk_name ])]);
            }
      
            $diff->each(function ($value) {
                Permission::create(['name' => $value]);
            });
            toastr()->success(__('custom_validation.record_create', ['attribute' => 'Bulk Permission']));
        }catch (Exception $e) {
            toastr()->error($e->getMessage());
        }

    }
}
