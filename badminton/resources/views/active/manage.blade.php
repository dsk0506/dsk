@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">配置赛事</div>

                <div class="panel-body">
                    <div>
                        选择类型 具体配置:<br>

                            <a href="{{url("distribution/$active_id/1")}}">单打循环</a>
                            <br>
                            <a href="{{url("distribution/$active_id/2")}}">双打循环</a>

                    </div>


                    <hr>
                    报名列表:
                    <div>
                    @if (count($result))
                        <table class="table">
                            <thead>
                            <tr>
                            <td>姓名</td>
                            <td>报名类型</td>
                            <td>报名时间</td>
                            <td>联系方式</td>
                            </tr>
                            </thead>
                          @foreach ($result as $item)

                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        {{$item->active_type==1?"单打":''}}
                                        {{$item->active_type==2?"双打":''}}
                                    </td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->phone}}</td>
                                </tr>

                          @endforeach
                        </table>
                    @else
                        还没有人报名哦
                    @endif


                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
