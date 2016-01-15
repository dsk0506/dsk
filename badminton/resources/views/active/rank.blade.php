@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">比赛成绩</div>

                <div class="panel-body">

                    <table class="table">
                    <thead>
                    <tr>
                        <td>名次</td><td>球队</td><td>胜场</td><td>胜局</td><td>胜分</td><td>战胜的对手</td>

                     </tr>
                    </thead>
                    @if(!empty($arr4))
                    @foreach($arr4 as $k =>$item)
                     <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['jsc']}}</td>
                        <td>{{$item['jsj']}}</td>
                        <td>{{$item['jsf']}}</td>
                        <td>
                            <?php
                            echo !empty($item['win'])?implode("<br>",$item['win']):"";
                            ?>
                        </td>
                     </tr>
                    @endforeach
                    @endif
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
