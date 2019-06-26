<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Dnote extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now =Carbon::now();
//Todo give each setting its id;
        \App\DnoteNumber::insert(
                [
                    'dnote_number'=>00001,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
    }
}
