<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleName;

class RoleNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $inputs = ["superadmin", "Kepala Club", "Pelatih", "Atlet"];
        RoleName::query()->truncate();
        foreach ($inputs as $input) {
            RoleName::create(['role_name' => $input]);
        }
    }
}
