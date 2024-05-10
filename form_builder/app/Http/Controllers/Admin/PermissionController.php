<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBulkPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
       
       $permissions = Permission::select('id', 'name');
        if ($request->ajax()) {
            return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('action', 'admin.permission.action')
            ->rawColumns(['name', 'action'])
            ->make(true);
        }
        return view('admin.permission.index');
    }

    public function createPermission(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
        ]);
       
        toastr()->success(__('custom_validation.record_create', ['attribute' => 'Permission']));
    
        return back();
    }

    public function bulkPermission(StoreBulkPermissionRequest $request)
    {
        $request->handle();

        return back();
    }
}
