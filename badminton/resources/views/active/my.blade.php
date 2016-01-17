@extends('layouts.app')

@section('content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">我发布的赛事</div>

                    <div class="panel-body">
                        @if (count($result))
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>标题</th>
                                    <th>发布时间</th>
                                    <th>结束时间</th>
                                    <th>我要管理</th>
                                </tr>
                                </thead>
                                @foreach ($result as $item)
                                    <tr>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->expire_time}}</td>
                                        <td>
                                            <a href="{{url("/success/$item->id")}}">查看</a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{url("/manage/$item->id")}}">管理</a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{url("/manage/set/$item->id")}}" target="_blank">设置裁判</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            我还没有赛事
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
