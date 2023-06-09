<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\Toolanswer;
use App\Models\Cabor;

class Tools extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $inputs = ["text","file","checkbox","radio","select"];
        // Toolanswer::query()->truncate();
        // foreach($inputs as $input){
        //     Toolanswer::create(['component'=>$input]);
        // }
        Cabor::query()->truncate();
        Cabor::create(['name' => 'PASI / ATLETIK', 'user_id' => 1]);
        Cabor::create(['name' => 'PERCASI / CATUR', 'user_id' => 1]);
        Cabor::create(['name' => 'PERKEMI / KAMPO', 'user_id' => 1]);
        Cabor::create(['name' => 'PERPANI / PANAHAN', 'user_id' => 1]);
        Cabor::create(['name' => 'PERSANI / SENAM', 'user_id' => 1]);
        Cabor::create(['name' => 'PERTINA / TINJU', 'user_id' => 1]);
        Cabor::create(['name' => 'PJSI / JUDO', 'user_id' => 1]);
        Cabor::create(['name' => 'POBSI / BILLIARD', 'user_id' => 1]);
        Cabor::create(['name' => 'PORSEROSI / SEPATU RODA', 'user_id' => 1]);
        Cabor::create(['name' => 'PSTI / TAKRAW', 'user_id' => 1]);
    }
}
