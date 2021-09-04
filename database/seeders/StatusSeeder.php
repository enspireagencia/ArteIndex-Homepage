<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Status;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['In Progress','Available', 'Reserved', 'Donated', 'Gifted', 'Sold','Not For Sale','On Loan','Work Destroyed','Archived','Lost','Stolen','Deaccessioned'];
        foreach ($status as $key => $status_val) {
            Status::updateOrCreate([
                'status' => $status_val,
            ]);
        }
    }
}
