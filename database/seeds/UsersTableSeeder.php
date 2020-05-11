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
          'name' => 'admin',
          'email' => 'admin@admin.com',
          'password' => Hash::make('admin123'),
          'role' => '0',
        ]);
    }
}
