<?php

namespace App\Listeners;

use App\Events\ActiveEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
class ActiveEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActiveEvent  $event
     * @return void
     */
    public function handle(ActiveEvent $event)
    {

        $config = $event->config;
        switch ($config['active_type'])
        {
            case 2:
                //根据配置获取参赛用户
                $users = DB::select("SELECT * FROM active_user LEFT JOIN `user` ON `user`.id = active_user.uid WHERE active_user.active_id = :active_id",array('active_id'=>$config['active_id']));
                $signCount = count($users);
                $groupCount = intval($signCount/2);
                if(empty($groupCount)){
                    return ;
                }

                for($i=0;$i<$groupCount;$i++){
                    $group[] = array(
                        'groupName'=>$users[$i*2]->name.":".$users[$i*2+1]->name,
                        'groupPhone'=>$users[$i*2]->phone.":".$users[$i*2+1]->phone,
                        'groupUid'=>array(
                            $users[$i*2]->id, $users[$i*2+1]->id
                        )
                    );

                }

                //循环赛
                if($config['active_rule']){
                    $period = explode('|',$config['active_period']);
                    foreach($period as $key=>$val){
                        $period[$key] = explode('~',$val);
                        $i=1;
                        while(date('Y-m-d H:i:s', $i*$event->config['active_time']*60+strtotime($period[$key][0]))<=$period[$key][1]){
                            $timeArr[] = date('Y-m-d H:i:s', ($i-1)*$event->config['active_time']*60+strtotime($period[$key][0]))."~".date('Y-m-d H:i:s', $i*$event->config['active_time']*60+strtotime($period[$key][0]));
                            $i++;
                        }
                    }

                    $match= $this->Combination($group);
                    foreach($timeArr as $key=>$val){
                        $result[$key]['time'] = $val;
                        $result[$key]['uid'] = array();
                        for($i=0;$i<$event->config['active_site'];$i++){
                            $j=0;
                            while(1){
                                $j++;
                                if(empty($match)){
                                    break;
                                }
                                $arr = array_shift($match);
                                $uid = array_merge($arr[0]['groupUid'],$arr[1]['groupUid']);
                                $uidArr = $result[$key]['uid'];
                                $uidArr1 = array();
                                $uidArr2 = array();

                                if($key>1){
                                    $uidArr1 = $result[$key-1]['uid'];
                                    $uidArr2 = $result[$key-2]['uid'];
                                }
                                if(array_intersect($uid,$uidArr)||(array_intersect($uid,$uidArr1)&&array_intersect($uid,$uidArr2))){
                                    array_push($match,$arr);
                                    if($j>count($match)){
                                        break;
                                    }
                                    continue;
                                }

                                $result[$key][$i] = $arr;
                                $result[$key]['uid'] = array_merge($result[$key]['uid'],$uid);
                                break;
                            }

                        }


                    }
                    $result['time'] = $timeArr;
                    $result['active_site'] = $config['active_site'];
                    return  $result;

                }
                break;
            case 1:
                //根据配置获取参赛用户
                $users = DB::select("SELECT * FROM active_user LEFT JOIN `user` ON `user`.id = active_user.uid WHERE active_user.active_id = :active_id and active_user.active_type = :active_type",array('active_id'=>$config['active_id'],'active_type'=>$config['active_type']));
                $signCount = count($users);
                $groupCount = intval($signCount);
                if(empty($groupCount)){
                    return ;
                }

                for($i=0;$i<$groupCount;$i++){
                    $group[] = array(
                        'groupName'=>$users[$i]->name,
                        'groupPhone'=>$users[$i]->phone,
                        'groupUid'=>array(
                            $users[$i]->id
                        )
                    );

                }

                //循环赛
                if($config['active_rule']){
                    $period = explode('|',$config['active_period']);
                    foreach($period as $key=>$val){
                        $period[$key] = explode('~',$val);
                        $i=1;
                        while(date('Y-m-d H:i:s', $i*$event->config['active_time']*60+strtotime($period[$key][0]))<=$period[$key][1]){
                            $timeArr[] = date('Y-m-d H:i:s', ($i-1)*$event->config['active_time']*60+strtotime($period[$key][0]))."~".date('Y-m-d H:i:s', $i*$event->config['active_time']*60+strtotime($period[$key][0]));
                            $i++;
                        }
                    }

                    $match= $this->Combination($group);
                    foreach($timeArr as $key=>$val){
                        $result[$key]['time'] = $val;
                        $result[$key]['uid'] = array();
                        for($i=0;$i<$event->config['active_site'];$i++){
                            $j=0;
                            while(1){
                                $j++;
                                if(empty($match)){
                                    break;
                                }
                                $arr = array_shift($match);
                                $uid = array_merge($arr[0]['groupUid'],$arr[1]['groupUid']);
                                $uidArr = $result[$key]['uid'];
                                $uidArr1 = array();
                                $uidArr2 = array();

                                if($key>1){
                                    $uidArr1 = $result[$key-1]['uid'];
                                    $uidArr2 = $result[$key-2]['uid'];
                                }
                                if(array_intersect($uid,$uidArr)||(array_intersect($uid,$uidArr1)&&array_intersect($uid,$uidArr2))){
                                    array_push($match,$arr);
                                    if($j>count($match)){
                                        break;
                                    }
                                    continue;
                                }

                                $result[$key][$i] = $arr;
                                $result[$key]['uid'] = array_merge($result[$key]['uid'],$uid);
                                break;
                            }

                        }


                    }
                    $result['time'] = $timeArr;
                    $result['active_site'] = $config['active_site'];
                    //var_dump($result);exit;
                    return  $result;

                    }
                    break;
        }

    }

    public function Combination($arr) {
        $len = count($arr);
        for($i=0;$i<$len;$i++){
            for($j=$i+1;$j<$len;$j++){
                $r_arr[] = array($arr[$i],$arr[$j]);
            }
        }
        return $r_arr;
    }
}
