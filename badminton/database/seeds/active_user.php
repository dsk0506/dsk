<?php

use Illuminate\Database\Seeder;

class active_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=2;$i<34;$i++){
            DB::table('active_user')->insert([
                'uid' =>$i,
                'active_id' => 1,
                'active_type' => 5,
            ]);
        }
    }
}
