<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('email','admin@gmail.com')->first();
        if(!isset($users)){
            User::updateOrCreate([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'user_role' => '1',
                'user_unique_id' => 'admin-'.time().uniqid('-', false).uniqid('-', false),
                'password' => bcrypt('123456'),
            ]);
        }
        
    }
}
