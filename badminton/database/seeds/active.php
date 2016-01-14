<?php

use Illuminate\Database\Seeder;

class active extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('active')->insert([
            'title' => "一个活动",
            'content' => "活动描述",
            'active_type' => json_encode(array(2)),
            'uid' => 1,
            'status'=>0,
            'expire_time'=>date('Y-m-d H:i:s',time()+86400*2)
        ]);
    }
}
