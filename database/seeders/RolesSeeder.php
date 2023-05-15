<?php

namespace Database\Seeders;
use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('user_roles')->delete();

    DB::table('user_roles')->insert(array (
        0 =>
        array (
            'id' => 1,
            'name' => 'user',
            'created_at' => '2021-06-04 10:31:46',
            'updated_at' => '2021-06-04 10:31:46',

        ),
        1 =>
        array (
            'id' => 2,
            'name' => 'driver',
            'created_at' => '2021-06-04 10:31:46',
            'updated_at' => '2021-06-04 10:31:46',

        ),
    ));

    }
}
