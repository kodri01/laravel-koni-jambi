<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::query()->truncate();
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.id',
            'password' => bcrypt('123123'),
            'active' => 99,
            'cabang_id' => 1
        ]);

        $admin->assignRole('superadmin');
    }
}
