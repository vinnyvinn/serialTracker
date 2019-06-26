<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Warrant;

class WarrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        Warrant::insert([
            [

                'wrty_type' => 'Labour',
                'wrty_duration' => 1,
                'description'=>'This is labour warranty number of years',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [

                'wrty_type' => 'Parts',
                'description'=>'This is Parts warranty number of years',
                'wrty_duration' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
            ,[

                'wrty_type' => 'Service',
                'wrty_duration' => 1,
                'description'=>'This is service warranty number of years',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
