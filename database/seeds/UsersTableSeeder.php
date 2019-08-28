<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => '金谷翔平',
                'mac_address' => 'AA:AA:AA:AA:AA:AA',
                'status_id' => 1
            ],
            [
                'name' => '金谷iPhone',
                'mac_address' => 'BB:BB:BB:BB:BB:BB',
                'status_id' => 2
            ]
        ]);
    }

}

