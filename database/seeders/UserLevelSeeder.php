<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserLevel;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'level' => 'APPRENTICE',
            ],
            [
                'level' => 'PROFESSIONAL',
            ],
            [
                'level' => 'MASTER',
            ],
        ];

        foreach ($levels as $key => $level) {
            UserLevel::updateOrCreate([
                'level' => $level['level'],
            ]);
        }
    }
}
