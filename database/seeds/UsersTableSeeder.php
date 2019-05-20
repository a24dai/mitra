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
            'name' => '安藤 大地',
            'mac_address' => '88:e9:fe:67:96:a7',
            'state' => 0,
        ]);
    }

}

