<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_status')->insert([
            'value' => 'admin',
        ]);

        DB::table('users_status')->insert([
            'value' => 'user',
        ]);

        DB::table('users')->insert([
            'id_status' => "1",
            'login' => 'admin',
            'password' => bcrypt('TestSystemAdmin'),
            'fullname' => 'Администратор',
            'group' => 'admins',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('settings')->insert([
            'key' => 'testing_time',
            'value' => '1 day',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
