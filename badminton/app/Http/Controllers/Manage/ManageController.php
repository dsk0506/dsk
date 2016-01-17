<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 16/1/17
 * Time: 16:33
 */
namespace App\Http\Controllers\Manage;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;

class ManageController extends Controller
{
    /**
     * 设置裁判页面
     */
    public function set($id){
        $data = array();
        $data['active_id']=$id;
        return view('manage.set',$data);
    }

    /**
     * 裁判数据的录入
     * @return mixed
     */
    public function doSet(){
        $rules = array(
            'mobile'=> 'required',
        );
        $postData = Input::all();
        $validator = Validator::make($postData, $rules);
        $active_id = Input::get('active_id');
        if($validator->fails()){
            return Redirect::to('manage/set/'.$active_id)->withErrors($validator);
        }
        $mobile = Input::get('mobile');
        //是否存在
        $exits = DB::table('user')->where('phone',$mobile)->first();
        $activeData = DB::table('active')->where('id',$active_id)->first();
        if($exits){
            //信息同步到active_manage中
            DB::table('active_manage')->insert(
                [
                    'uid'=>$exits->id,
                    'username'=>$exits->name,
                    'mobile'=>$exits->phone,
                    'active_id'=>$active_id,
                    'active_type'=>$activeData->active_type
                ]
            );
        }else{
            //注册账号,并且写入manage
            //user表写入数据,注册
            DB::table('user')->insert(
                [
                    'name'=>$postData['nickname'],
                    'phone'=>$postData['mobile'],
                    'password'=>md5($postData['password'])
                ]
            );
            $lastUid = DB::getPdo()->lastInsertId();
            DB::table('active_manage')->insert(
                [
                    'uid'=>$lastUid,
                    'username'=>$postData['nickname'],
                    'mobile'=>$postData['mobile'],
                    'active_id'=>$active_id,
                    'active_type'=>$activeData->active_type
                ]
            );
        }
        echo "<script>alert('设置裁判成功');</script>";
        return redirect('/');
    }
}