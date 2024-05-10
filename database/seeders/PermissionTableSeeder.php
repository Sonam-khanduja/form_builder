<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**

     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
        DB::table('permissions')->delete();
        
        DB::table('permissions')->insert(array (
            0 => array (
                'name' => 'user.list',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => array (
                'name' => 'user.create',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            2 => array (
                'name' => 'user.edit',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            3 => array (
                'name' => 'role.list',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            4 => array (
                'name' => 'role.create',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            5 => array (
                'name' => 'role.edit',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            6 => array (
                'name' => 'role.delete',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            7 => array (
                'name' => 'dashboard.access',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            )
          
        ));
     }
}
