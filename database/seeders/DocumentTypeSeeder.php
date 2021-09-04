<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\DocumentType;
class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            [
                'name' => 'Resume',
            ],
            [
                'name' => 'Bio',
            ],
            [
                'name' => 'Statement',
            ],
            [
                'name' => 'Proposal',
            ],
            [
                'name' => 'Press',
            ],
            [
                'name' => 'Other',
            ],
        ];

        foreach ($type as $key => $type_val) {
            DocumentType::updateOrCreate([
                'name' => $type_val['name'],
            ]);
        }
    }
}
