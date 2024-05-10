<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'sonam.khanduja@devitpl.com',
                'is_admin' => '1',
                'status'  => '1',
                'password' => bcrypt('123456'),
            ],
            [
            'name' => 'User',
            'email' => 'sonamkhanduja.devitpl@gmail.com',
            'is_admin' => '0',
            'status'  => '1',
            'password' => bcrypt('123456'),
            ],
        ];

    foreach ($user as $key => $value) {
        User::create($value);
    }
}
}
