<?php

use Illuminate\Database\Seeder;

class user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<34;$i++){
            $var=sprintf("%02d", $i);
            DB::table('user')->insert([
                'name' => "丁守坤".$i,
                'phone' => "186163699".$var,
                'password' => md5("123456"),
            ]);
        }
    }
}
