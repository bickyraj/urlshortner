<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        // add admin to users table.
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'role_id' => 1,
            'password' => bcrypt('test123'),
        ]);

        // add admin role to roles table
        DB::table('roles')->insert([
            'name' => 'admin',
            'status' => 1,
        ]);

    }
}
