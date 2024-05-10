<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\SendCodeMail;
use DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'status',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     /**
     * Generating code for 2-factor-auth
     *
     * @var integer
     */

    public function generateCode()
    {
        $code = rand(1000, 9999);

        UserCode::updateOrCreate(
            [ 'user_id' => auth()->id() ],
            [ 'code' => $code ]
        );

        try {

            $details = [
                'title' => 'Mail For 2way auth Code.',
                'code' => $code
            ];
        
            Mail::to(auth()->user()->email)->send(new SendCodeMail($details));

        } catch (\Exception $e) {
            info("Error: ". $e->getMessage());
            dd($e);
        }
    }

     /**
     * update Status
     *
     * @Query <integer, integer>
     */
    public function updateUserStatus($id,$status)
    {        
        User::where('id', '=', $id)
            ->update([
              'status' => $status,
            ]);
   }

    /**
     * Destroy Session when user login other device
     *
     * @Query <integer>
    */
    public function userSessionDestroyOtherDevice($id)
    {
        DB::table('sessions')->where('user_id', $id)->delete();        
    }

    /**
     *For Admin can see all user list
     *
     * @Query <integer> using Auth Id
    */
    public function getAllUserlist()
    {               
       $users = User::select('id', 'name','email', 'status', 'created_at')
                ->where('id', '!=', auth()->user()->id);
        return  $users;
    }


    /**
     * Update User Details by Admin
     *
     * @Query <integer>,Request
    */
    public function updateUserDetail($request,$id)
    {       
        User::find($id)->fill([
            'name' => $request['name'],          
            'email' => $request['email'],        
            'status' => $request['status'],
            'password' => Hash::make($request['password']),                    
         ])->save();       
    }


    /**
     * Delete a User by Admin
     *
     * @Query <integer>,Request
    */
    public function deleteUserByAdmin($id)
    {
        $user = User::find($id)->delete();       
        return $user;
    }


}
