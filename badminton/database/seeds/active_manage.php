<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 16/1/17
 * Time: 15:40
 */
use Illuminate\Database\Seeder;
class active_manage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('active_manage')->insert([
            'uid' =>1,
            'username'=>'lock',
            'mobile'=>'15105661487',
            'active_id' => 1,
            'active_type' => 2,
        ]);
    }
}
