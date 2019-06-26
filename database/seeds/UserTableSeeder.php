<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        User::truncate();
        User::insert([
            [
                'name' => 'admin',
                'email' => 'serialtracker@wizag.biz',
                'password' => bcrypt('qwerty123'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'vinny',
                'email' => 'vinn@wizag.biz',
                'password' => bcrypt('12345678'),
                'created_at' => $now,
                'updated_at' => $now
            ]
            ,[
                'name' => 'quest',
                'email' => 'guest@wizag.biz',
                'password' => bcrypt('quest2016'),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

}
}
