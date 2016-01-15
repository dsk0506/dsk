<?php

namespace App\Http\Controllers\Active;

use App\Events\ActiveEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Cookie;
use Event;
class IndexController extends Controller
{

    public function send(){
        return view('active.send');
    }

    public function sendDo(){

        // create the validation rules ------------------------
        $rules = array(
            'title'             => 'required',                        // just a normal required validation
            'content'            => 'required',     // required and must be unique in the ducks table
            'expire_time'         => 'required',
            'active_type' => 'required'           // required and has to match the password field
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('send')
                ->withErrors($validator)
                ->withInput(Input::all());

        } else {
            //注册 登陆
            DB::table('active')->insert(
                [
                    'title'=>Input::get('title'),
                    'content'=>Input::get('content'),
                    'expire_time'=>Input::get('expire_time'),
                    'active_type'=>json_encode(Input::get('active_type')),
                    'uid'=>cookie::get('uid')

                ]
            );
            $id = DB::getPdo()->lastInsertId();
            return Redirect::to('/success/'.$id);

        }

    }

    public function success($active_id){
        $uid = cookie::get('uid');
        $sendInfo = DB::table('active')->where('id',$active_id)->first();
        $url  = config('app.url')."/sign/".$active_id;
        if(empty($sendInfo)){
            return Redirect('/');
        }
        if($uid!=$sendInfo->uid){
            return Redirect($url);
        }
        return view('active.success',compact('url'));
    }

    /**
     * 报名表单展示
     * @param $active_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sign($active_id){
        $result = DB::table("active")->where('id',$active_id)->first();
        $uid = cookie::get('uid');
        if($uid==$result->uid){
            echo "<script>alert('自己不能参加自己发布的活动!');history.back()</script>";
            exit();
        }
        $activeType = json_decode($result->active_type,JSON_UNESCAPED_UNICODE);
        //活动内容展示
        $data = array(
            'activeId'=>$result->id,
            'title'=>$result->title,
            'content'=>$result->content,
            'activeType'=>$activeType,
            'isLogin'=>$uid
        );
        return view('active.sign',$data);
    }

    /**
     * 进行报名
     */
    public function signDo(){
        $rules = array(
            'active_type'=> 'required',
        );
        $postData = Input::all();
        $validator = Validator::make($postData, $rules);
        if($validator->fails()){
            return Redirect::to('sign/'.Input::get('activeId'))->withErrors($validator);
        }
        $uid = cookie::get('uid');
        if($uid){
            //报名
            foreach($postData['active_type'] as $type){
                DB::table('active_user')->insert(
                    [
                        'uid'=>$uid,
                        'active_id'=>Input::get('activeId'),
                        'active_type'=>$type
                    ]
                );
            }
        }else{
            //注册+报名
            $phone = Input::get('phone');
            $name = Input::get('name');
            $rules = array(
                'phone'=> 'required',
                'name'=>'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if($validator->fails()){
                return Redirect::to('sign/'.Input::get('activeId'))->withErrors($validator);
            }
            $pass='111111';
            //user表写入数据,注册
            DB::table('user')->insert(
                [
                    'name'=>$name,
                    'phone'=>$phone,
                    'password'=>md5($pass)
                ]
            );
            //设置登陆
            $lastUid = DB::getPdo()->lastInsertId();
            cookie::queue('uid',$lastUid,86400);
            cookie::queue('name',$name,86400);
            cookie::queue('phone',$phone,86400);
            //报名
            foreach($postData['active_type'] as $type){
                DB::table('active_user')->insert(
                    [
                        'uid'=>$lastUid,
                        'active_id'=>Input::get('activeId'),
                        'active_type'=>$type
                    ]
                );
            }
        }
        return redirect('/');
    }

    /**
     * 我的赛事
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function my(){
        $uid = cookie::get('uid');
        $result = DB::select("select * from active where uid=:uid order by expire_time desc",array('uid'=>$uid));
        return view('active.my',compact('result'));
    }

    public function manage($active_id){
        $uid = cookie::get('uid');
        $sendInfo = DB::table('active')->where('id',$active_id)->first();
        $url  = config('app.url')."/sign/".$active_id;
        if(empty($sendInfo)){
            return Redirect('/');
        }
        if($uid!=$sendInfo->uid){
            return Redirect($url);
        }
        $result = DB::select("SELECT * FROM active_user LEFT JOIN `user` ON `user`.id = active_user.uid WHERE active_user.active_id = :active_id",array('active_id'=>$active_id));
        $active_type = json_decode($sendInfo->active_type);

        return view('active.manage',compact('result','active_type','active_id'));
    }

    public function distribution($active_id,$active_type){
        $config=array(
            'active_id'=>$active_id,//活动id
            'active_type'=>$active_type,//1双打 2单打
            'active_rule'=>1,//1循环
            'active_site'=>3,//场地
            'active_period'=>'2016-01-05 09:00:00~2016-01-05 11:00:00|2016-01-05 13:00:00~2016-01-05 15:00:00|2016-01-06 09:00:00~2016-01-06 11:00:00',//时间段
            'active_time'=>10,//每场需要时间 单位分钟

        );
        $data = Event::fire(new ActiveEvent($config));
        $result = $data[0];
        //var_dump($result);
        return view('active.distribution',compact('result','active_id','active_type'));
    }

    public function enter($active_id,$group_name,$group_uid,$active_type){

        $result = DB::select("SELECT * FROM active_match_score  WHERE active_id = :active_id and group_name=:group_name and group_uid=:group_uid ORDER BY created_at asc",array('active_id'=>$active_id,'group_name'=>$group_name,"group_uid"=>$group_uid));
        return view('active.enter',compact('result','group_name','active_id','group_uid','active_type'));
    }


    public function enterDo(){
        DB::table('active_match_score')->insert(
            [
                'group_name'=>Input::get('group_name'),
                'active_id'=>Input::get('active_id'),
                'group_uid'=>Input::get('group_uid'),
                'score1'=>Input::get('score1'),
                'score2'=>Input::get('score2'),
                'active_type'=>Input::get('active_type'),
                'uid'=>cookie::get('uid')
            ]
        );
        return Redirect::to('/enter/'.Input::get('active_id')."/".Input::get('group_name')."/".Input::get('group_uid')."/".Input::get('active_type'));

    }

    public function rank($active_id,$active_type){
        $result = DB::select("SELECT * FROM active_match_score  WHERE active_id = :active_id and active_type = :active_type   ORDER BY created_at asc",array('active_id'=>$active_id,'active_type'=>$active_type));
        $rankArr = array();
        if(empty($result)){
            return view('active.rank');
        }
        foreach($result as $v){
            $arr = array_shift($result);
            $groupArr[$arr->group_name][] = $v;

        }
        foreach($groupArr as $k=>$v){
            if(count($v)==1){
                $name = explode('~',$k);
                $arr1[$name[0]]['name'] = $name[0];
                $arr1[$name[1]]['name'] = $name[1];

                if($v[0]->score1>$v[0]->score2){
                    $arr1[$name[0]]['jsc'] = (empty($arr1[$name[0]]['jsc'])?0:$arr1[$name[0]]['jsc']) + 1;
                    $arr1[$name[1]]['jsc'] = (empty($arr1[$name[1]]['jsc'])?0:$arr1[$name[1]]['jsc']) + 0;
                    $arr1[$name[0]]['jsj'] = (empty($arr1[$name[0]]['jsj'])?0:$arr1[$name[0]]['jsj']) + 1;
                    $arr1[$name[1]]['jsj'] = (empty($arr1[$name[1]]['jsj'])?0:$arr1[$name[1]]['jsj']) + 0;
                    if(empty($arr1[$name[0]]['win'])){
                        $arr1[$name[0]]['win'][] = $name[1];
                    }else{
                        if(!in_array($name[1],$arr1[$name[0]]['win'])){
                            $arr1[$name[0]]['win'][] = $name[1];
                        }
                    }
                }else{
                    $arr1[$name[0]]['jsc'] = (empty($arr1[$name[0]]['jsc'])?0:$arr1[$name[0]]['jsc']) + 0;
                    $arr1[$name[1]]['jsc'] = (empty($arr1[$name[1]]['jsc'])?0:$arr1[$name[1]]['jsc']) + 1;
                    $arr1[$name[0]]['jsj'] = (empty($arr1[$name[0]]['jsj'])?0:$arr1[$name[0]]['jsj']) + 0;
                    $arr1[$name[1]]['jsj'] = (empty($arr1[$name[1]]['jsj'])?0:$arr1[$name[1]]['jsj']) + 1;
                    if(empty($arr1[$name[1]]['win'])){
                        $arr1[$name[1]]['win'][] = $name[0];
                    }else{
                        if(!in_array($name[0],$arr1[$name[1]]['win'])){
                            $arr1[$name[1]]['win'][] = $name[0];
                        }
                    }
                }
                //var_dump($arr1);exit;
            }else{
                $name = explode('~',$k);
                $arr1[$name[0]]['name'] = $name[0];
                $arr1[$name[1]]['name'] = $name[1];
                $score1 = 0;
                $score2 = 0;
                foreach($v as $v1){
                    if($v1->score1>$v1->score2){
                        $score1 = $score1+1;
                    }else{
                        $score2 = $score2+1;
                    }
                }
                if($score1>$score2){
                    $arr1[$name[0]]['jsc'] = (empty($arr1[$name[0]]['jsc'])?0:$arr1[$name[0]]['jsc']) + 1;
                    $arr1[$name[1]]['jsc'] = (empty($arr1[$name[1]]['jsc'])?0:$arr1[$name[1]]['jsc']) + 0;
                    $arr1[$name[0]]['jsj'] = (empty($arr1[$name[0]]['jsj'])?0:$arr1[$name[0]]['jsj']) + $score1-$score2;
                    $arr1[$name[1]]['jsj'] = (empty($arr1[$name[1]]['jsj'])?0:$arr1[$name[1]]['jsj']) + 0;
                    if(empty($arr1[$name[0]]['win'])){
                        $arr1[$name[0]]['win'][] = $name[1];
                    }else{
                        if(!in_array($name[1],$arr1[$name[0]]['win'])){
                            $arr1[$name[0]]['win'][] = $name[1];
                        }
                    }
                }elseif($score1==$score2){
                    $arr1[$name[0]]['jsc'] = (empty($arr1[$name[0]]['jsc'])?0:$arr1[$name[0]]['jsc']) + 0;
                    $arr1[$name[1]]['jsc'] = (empty($arr1[$name[1]]['jsc'])?0:$arr1[$name[1]]['jsc']) + 0;
                    $arr1[$name[0]]['jsj'] = (empty($arr1[$name[0]]['jsj'])?0:$arr1[$name[0]]['jsj']) + 0;
                    $arr1[$name[1]]['jsj'] = (empty($arr1[$name[1]]['jsj'])?0:$arr1[$name[1]]['jsj']) + 0;
                    $arr1[$name[0]]['win'][] = "进行中";
                    $arr1[$name[1]]['win'][] = "进行中";
                }else{
                    $arr1[$name[0]]['jsc'] = (empty($arr1[$name[0]]['jsc'])?0:$arr1[$name[0]]['jsc']) + 0;
                    $arr1[$name[1]]['jsc'] = (empty($arr1[$name[1]]['jsc'])?0:$arr1[$name[1]]['jsc']) + 1;
                    $arr1[$name[0]]['jsj'] = (empty($arr1[$name[0]]['jsj'])?0:$arr1[$name[0]]['jsj']) + 0;
                    $arr1[$name[1]]['jsj'] = (empty($arr1[$name[1]]['jsj'])?0:$arr1[$name[1]]['jsj']) + $score2-$score1;
                    if(empty($arr1[$name[1]]['win'])){
                        $arr1[$name[1]]['win'][] = $name[0];
                    }else{
                        if(!in_array($name[0],$arr1[$name[1]]['win'])){
                            $arr1[$name[1]]['win'][] = $name[0];
                        }
                    }
                }
            }

        }

        //先按净身场 如果净身场相同 再比较他们的胜负
        uasort($arr1,function($a,$b){
            if($b['jsc']>$a['jsc']){
                return 1;
            }elseif($b['jsc']==$a['jsc']){
                if(!empty($b['win'])){
                    if(in_array($a['name'],$b['win'])){
                        return 1;
                    }
                }

            }
        });
        $arr4 = array_values($arr1);
        return view('active.rank',compact('arr4'));
    }
}
