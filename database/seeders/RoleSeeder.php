<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Kepala Club',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Pelatih',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Atlet',
            'guard_name' => 'web'
        ]);

        // Role::create([
        //     'name' => 'Club Members',
        //     'guard_name' => 'web'
        // ]);

        // Role::create([
        //     'name' => 'Event Organization',
        //     'guard_name' => 'web'
        // ]);
    }
}
