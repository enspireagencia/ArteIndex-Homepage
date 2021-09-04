<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\UserStatus;
class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Artists',
            ],
            [
                'name' => 'Galleries',
            ],
            [
                'name' => 'Institutions',
            ],
        ];

        foreach ($status as $key => $status_val) {
            UserStatus::updateOrCreate([
                'status' => $status_val['name'],
            ]);
        }
    }
}
