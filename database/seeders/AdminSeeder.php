<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Schema::disableForeignKeyConstraints();
       $existUser = User::where('email', 'sonam.khanduja@devitpl.com')->first();       
       $role = Role::create(['name' => 'Admin']);
       $permissions = Permission::pluck('id','id')->all();   
       $role->syncPermissions($permissions);

       if (empty($existUser)) {
           $user = User::create([
                   'name' => 'Sonam',
                   'email' => 'sonam.khanduja@devitpl.com',
                   'status' => 1,
                   'email_verified_at' => null,
                   'password' => bcrypt('123456'),
                   'created_at' => now(),
                   'updated_at' => now(),             
           ]);             
           $user->assignRole(config('const.ROLES.ADMIN'));     
           $user->assignRole([$role->name]);  
       }else {
          $existUser->assignRole(config('const.ROLES.ADMIN'));
       }
    }
}
