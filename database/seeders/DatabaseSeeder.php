<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UserLevelSeeder::class,
            UserStatusSeeder::class,
            CountrySeeder::class,
            ArtTypeSeeder::class,
            StatusSeeder::class,
            DocumentTypeSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
