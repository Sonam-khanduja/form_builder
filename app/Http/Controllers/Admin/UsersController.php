<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller {

    public function __construct()
    {
        
        $this->userModelObj = new User();
    }
    /**
     * Display a listing of the users records.
     *
     * @author DEVIT
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userlist = $this->userModelObj->getAllUserlist();
        $userAuth = auth()->user();
        if ($request->ajax()) {
            return DataTables::of($userlist)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
   
            ->addColumn('status', function ($row) use ($userAuth) {
                if ($userAuth->can('users.edit')) {                    
                    $status = '<select data-id="'.$row->id.'" class="form-select form-control changeStatus" name="status">
                    <option value="0"' . ($row->status == 0 ? ' selected' : '') . '>Inactive</option>
                    <option value="1"' . ($row->status == 1 ? ' selected' : '') . '>Active</option>
                </select>';                
                }else {

                    if ($row->status == 0) {
                        $status = '<span>'.__('Inactive').'</span>';
                    }else {
                        $status = '<span>'.__('Active').'</span>';
                    }
                }
                return $status;
            })          
       
            ->addColumn('user_id', function ($row) {
                return $row->id;
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->toFormattedDateString();
            })
            ->editColumn('action', 'admin.users.action')
            ->rawColumns(['name','email','role','status','action'])
            ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * This method used Show the form for creating a new user
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
       return view('admin.users.create');
    }

     /**
     * This method used Show the form for Edit a new user
     *
     * @author DEVIT
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $userDetails = User::find($id);  
      
        return view('admin.users.edit', compact('userDetails'));
    }

    /**
     * This method used to store a user into database
     *
     * @author DEVIT
     * @param  \Illuminate\Http\StoreUserRequest  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {       
        $createUserObject = [
            'email' => $request->email,
            'status' => $request->status,
            'name' => $request->name,
            'password'=>Hash::make($request->userpassword)
        ];
      
        DB::beginTransaction();
        try {
            $createUser = User::create($createUserObject);
            DB::commit();
            toastr()->success(__('custom_validation.record_create', ['attribute' => 'User']));
            return redirect("admin/users");            
           
        }catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        return back();

    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {       
        $this->userModelObj->updateUserDetail($request,$id); 
        toastr()->success(__('custom_validation.record_update', ['attribute' => 'User']));
        return redirect('/admin/users');
    }

    /**
     * This method used to delete a specific user
     *
     * @author DEVIT
     * @param  \Illuminate\Http\user  $user
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {
            $this->userModelObj->deleteUserByAdmin($id);
            toastr()->success(__('custom_validation.record_delete', ['attribute' => 'User']));
            return back();
        }else {
            toastr()->error(__('404 | custom_validation.record_delete', ['attribute' => 'User']));
            return back();
        }
    }

    
}
