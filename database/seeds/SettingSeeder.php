<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Setting;

class SettingSeeder extends Seeder
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
        Setting::truncate();
        Setting::insert(
           [
               [
                'title'=>'Number of Serials',
                'setting_id'=>1,
                'description'=>'Set the number of serials you will capture from an item, the default value is four',
                'default_value'=>4,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title'=>'Primary Serial Column',
                'setting_id'=>2,
                'description'=>'Set the main primary serial column,the default value is 1',
                'default_value'=>1,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ]
            ,
            [
                'title'=>'Delivery note Type',
                'setting_id'=>3,
                'description'=>'Set the type of delivery note you will use, the default value is Consolidated',
                'default_value'=>1,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ]
            ,
            [
                'title'=>'Delivery note Number Prefix',
                'setting_id'=>4,
                'description'=>'Set the delivery note prefix for example DN',
                'default_value'=>771,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ]
            ,
            [
                'title'=>'Delivery note Number length',
                'setting_id'=>5,
                'description'=>'Set the delivery note number length, the length of numbering, example -00001',
                'default_value'=>5,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ]
               ,
            [
                'title'=>'Serial validation type',
                'setting_id'=>6,
                'description'=>'Set the the validation type , Validate on serial entry or bulk validation',
                'default_value'=>1,
                'status'=>'not',
                'created_at' => $now,
                'updated_at' => $now
            ],
               [
                   'title'=>'Tracking linked to',
                   'setting_id'=>7,
                   'description'=>'Set tracking linked to, the default value is PO',
                   'default_value'=>1,
                   'status'=>'not',
                   'created_at' => $now,
                   'updated_at' => $now
               ],
               [
               'title'=>'Strict Serial Tracking',
               'setting_id'=>8,
               'description'=>'Set Strict Serial Tracking,the default value is NO',
               'default_value'=>1,
               'status'=>'not',
               'created_at' => $now,
               'updated_at' => $now
           ],
               ['title'=>'Serial Tracking Method',
               'setting_id'=>9,
               'description'=>'Set Tracking Method,the default value is FIFO',
               'default_value'=>1,
               'status'=>'not',
               'created_at' => $now,
               'updated_at' => $now
           ],
           ]

        );
    }
}
