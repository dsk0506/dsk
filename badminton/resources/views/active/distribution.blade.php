@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">赛事安排(<a href="{{url("/rank/$active_id")}}">查看排名</a>)</div>

                <div class="panel-body">
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>时间段</td>
                                    @for ($i = 0; $i < $result['active_site']; $i++)
                                        <td>
                                            场地{{$i+1}}
                                        </td>
                                    @endfor
                                </tr>
                            </thead>
                            @for($j = 0; $j < count($result['time']); $j++)
                                <tr>
                                    <td>{{$result['time'][$j]}}</td>
                                    @for ($i = 0; $i < $result['active_site']; $i++)

                                        <td>
                                            <?php echo !empty($result[$j][$i][0]['groupName'])?$result[$j][$i][0]['groupName']."<br>".$result[$j][$i][1]['groupName']."<br><a href='/enter/".$active_id."/".$result[$j][$i][0]['groupName']."~".$result[$j][$i][1]['groupName']."/".$result[$j][$i][0]['groupUid'][0].":".$result[$j][$i][1]['groupUid'][0]."/$active_type'>录入比赛成绩</a>":'--';?>
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
