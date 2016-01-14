<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Cookie;
class AuthController extends Controller
{
    public function login(){

        return view('auth.login');
    }

    public function loginDo(){
        // create the validation rules ------------------------

        $rules = array(
            'phone'            => 'required|phone',     // required and must be unique in the ducks table
            'password'         => 'required|min:6',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator);

        } else {
            //注册 登陆
            $user = DB::table('user')
                ->where('phone',Input::get('phone'))
                ->where('password',md5(Input::get('password')))
                ->first();
            /*$queries = DB::getQueryLog();
            var_dump($queries);
            var_dump($admin);

            exit;*/
            if(!empty($user->id)){
                cookie::queue('uid',$user->id,86400);
                cookie::queue('name',$user->name,86400);
                cookie::queue('phone',$user->phone,86400);
                $validator->errors()->add('message','欢迎'.$user->name.'登陆成功!');
                return redirect('/')
                    ->withErrors($validator);
            }else{
                $validator->errors()->add('message','请输入正确的账号密码');
                return redirect('login')
                    ->withErrors($validator);
            }

        }
    }
    public function register(){

        return view('auth.register');
    }

    public function registerDo(){
        // create the validation rules ------------------------
        $rules = array(
            'name'             => 'required',                        // just a normal required validation
            'phone'            => 'required|phone|unique:user',     // required and must be unique in the ducks table
            'password'         => 'required|min:6',
            'password_confirmation' => 'required|same:password'           // required and has to match the password field
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('register')
                ->withErrors($validator)
                ->withInput(Input::all());

        } else {
            //注册 登陆
            DB::table('user')->insert(
                [
                    'name'=>Input::get('name'),
                    'phone'=>Input::get('phone'),
                    'password'=>md5(Input::get('password'))
                ]
            );
            $id = DB::getPdo()->lastInsertId();
            cookie::queue(cookie::make('uid',$id,86400));
            cookie::queue(cookie::make('name',Input::get('name'),86400));
            cookie::queue(cookie::make('phone',Input::get('phone'),86400));
            return Redirect::to('/');

        }
    }

    public function logout(){
        cookie::queue('uid',null,-1);
        cookie::queue('name',null,-1);
        cookie::queue('phone',null,-1);
        return redirect('/');
    }
}
