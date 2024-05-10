<?php 
namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Yajra\DataTables\DataTables;
    
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
        $roles = Role::withCount('users');     
        if ($request->ajax()) {
            return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('users_count', function ($row) {
                return $row->users_count;
            })
            ->editColumn('action', 'admin.roles.action')
            ->rawColumns(['name', 'action'])
            ->make(true);
        }
        return view('admin.roles.index');
    }
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolePermission = Permission::select('name', 'id')->get();

        $customPermission = array();

        foreach ($rolePermission as $per) {
            $key = substr($per->name, 0, strpos($per->name, "."));
            if (str_starts_with($per->name, $key)) {
                $customPermission[$key][] = $per;
            }
        }

        return view('admin.roles.create', compact('customPermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            foreach ($request->permissions as $value) {
                $role->givePermissionTo($value);
            }
        }
        toastr()->success(__('custom_validation.record_create', ['attribute' => 'Role']));
        return redirect(route('roles.index'));
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       /** @var \App\Models\User $user*/
        $user = auth()->user();
      
        // if (in_array($id, config('const.RESERVED_ROLE_ID')) && ($user->getRoleNames()[0] != config('const.ROLES.SYSTEM_ADMINISTRATOR'))) {
        //     toastr()->error(__('custom_validation.system_role_not_edit'));
        //     return redirect(route('roles.index'));
        // }

        $role = Role::with('permissions')->find($id);

        $rolePermission = Permission::select('name', 'id')->get();      

        $customPermission = array();

        foreach ($rolePermission as $per) {
            $key = substr($per->name, 0, strpos($per->name, "."));

            if (str_starts_with($per->name, $key)) {
                $customPermission[$key][] = $per;
            }
        }
        // echo "Custom Permissions";
        // print_r( $customPermission);
        // dd("=========");
        return view('admin.roles.edit', compact('rolePermission', 'role', 'customPermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreRoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        /** @var \App\Models\User $user*/     
        $user = auth()->user();     

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        toastr()->success(__('custom_validation.record_update', ['attribute' => 'Role']));
        return back();
    }

}
