<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::insert([
          'name' => 'pharmcist',
          'email' => 'pharmcist@pharmcist.com',
          'password' => Hash::make('pharmcist'),
          'role' => '0',
        ]);
    }
}
